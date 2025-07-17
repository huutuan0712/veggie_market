<?php

namespace App\Services;

use App\DTOs\Rating\RatingCollection;
use App\Models\Rating;
use App\DTOS\Rating\Rating as RatingDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RatingService extends BaseService
{
    /**
     * @var Rating|Builder
     */
    protected Model|Builder $model;

    public function __construct(Rating $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): Rating
    {
        return parent::create($attributes);
    }

   public function createDTO(RatingDTO $dto): array
   {
       $attributes = $dto->toArray();
       $this->create($attributes);

       $ratingCount = $this->model->where('product_id', $dto->product_id)->count();
       $averageRating = $this->model->where('product_id', $dto->product_id)->avg('rating');

       return [
           'ratingCount'    => $ratingCount,
           'averageRating'  => round($averageRating, 1),
       ];
   }

    public function update(string|int $id, array $attributes): Rating
    {
        return parent::update($id, $attributes);
    }

    public function updateDTO(string|int $id, RatingDTO $dto): array
    {
        $attributes = $dto->toArray();

        $rating = $this->update($id, $attributes);

        $ratingCount = $this->model->where('product_id', $dto->product_id)->count();
        $averageRating = $this->model->where('product_id', $dto->product_id)->avg('rating');

        return [
            'rating'        => RatingDTO::fromModel($rating),
            'ratingCount'   => $ratingCount,
            'averageRating' => round($averageRating, 1),
        ];
    }

    public function getPaginatedList(array $params = []): RatingCollection
    {
        $page = $params['page'] ?? 1;
        $perPage = $params['per_page'] ?? 15;
        $perPage = min($perPage, 100); // Maximum 100 items per page
        $search = $params['search'] ?? null;
        $sortBy = $params['sort_by'] ?? 'name';
        $sortDirection = $params['sort_direction'] ?? 'asc';
        $includeDeleted = $params['include_deleted'] ?? false;

        $query = $this->model->query();

        // Include soft deleted items if requested
        if ($includeDeleted) {
            $query->withTrashed();
        }

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $query->orderBy($sortBy, $sortDirection);

        // Get paginated results
        $ratings = $query->paginate($perPage, ['*'], 'page', $page);

        return RatingCollection::fromPaginator($ratings);
    }

   public function getRatings(int $productId): array
    {
        $ratings = $this->model->with('user')
            ->where('product_id', $productId)
            ->latest()
            ->get();

        $data = $ratings->map(function ($rating) {
            return [
                'id'         => $rating->id,
                'userName'   => $rating->user->name,
                'userAvatar' => $rating->user->avatar_url,
                'rating'     => $rating->rating,
                'date'       => $rating->created_at->format('d/m/Y'),
                'comment'    => $rating->comment,
                'helpful'    => $rating->helpful ?? 0,
            ];
        });

        $averageRating = $ratings->avg('rating');

        $ratingDistribution = collect([5, 4, 3, 2, 1])->map(function ($rating) use ($ratings) {
            $count = $ratings->where('rating', $rating)->count();
            $percentage = $ratings->count() > 0 ? ($count / $ratings->count()) * 100 : 0;
            return [
                'rating' => $rating,
                'count' => $count,
                'percentage' => round($percentage, 1),
            ];
        });

        return [
            'ratings'               => $data,
            'ratingCount'       => $ratings->count(),
            'averageRating'      => round($averageRating, 1),
            'ratingDistribution' => $ratingDistribution,
        ];
    }

    public function getRatingWithRelations($id): Rating
    {
        $query = $this->model->newQuery();
        $rating = $query->findOrFail($id);

        return RatingDTO::fromModel($rating);
    }

   public function destroy($id): array
    {
        $rating = $this->model->findOrFail($id);
        $productId = $rating->product_id;

        $rating->delete();

        $ratingCount = $this->model->where('product_id', $productId)->count();
        $averageRating = $this->model->where('product_id', $productId)->avg('rating') ?? 0;

        return [
            'ratingCount'   => $ratingCount,
            'averageRating' => round($averageRating, 1),
        ];
    }


}
