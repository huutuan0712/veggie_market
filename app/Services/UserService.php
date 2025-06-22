<?php

namespace App\Services;

use App\DTOs\User\UserCollection;
use App\Models\User;
use App\DTOS\User\User as UserDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService extends BaseService
{
    /**
     * @var User|Builder
     */
    protected Model|Builder $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): User
    {
        return parent::create($attributes);
    }

    public function createDTO (UserDTO $dto): ?UserDTO
    {
        $attributes = $dto->toArray();

        $user = $this->create($attributes);
        $user->assignRole('user');
        $user->sendEmailVerificationNotification();

        return UserDTO::fromModel($user);
    }

    public function update(string|int $id, array $attributes): User
    {
       return parent::update($id, $attributes);
    }

    public function updateDTO ($id, UserDTO $dto): ?UserDTO
    {
        $attributes= [];

        $user = $this->update($id, $attributes);
        return UserDTO::fromModel($user);
    }


     public function getPaginatedList(array $params = []): UserCollection
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
                 $q->where('username', 'like', "%{$search}%")
                     ->orWhere('full_name', 'like', "%{$search}%")
                     ->orWhere('address', 'like', "%{$search}%");
             });
         }

         // Apply sorting
         $query->orderBy($sortBy, $sortDirection);

         // Get paginated results
         $authors = $query->paginate($perPage, ['*'], 'page', $page);

         return UserCollection::fromPaginator($authors);
     }


     public function getUserWithRelations ($id): ?UserDTO
     {
        $query = $this->model->newQuery();
        $user = $query->findOrFail($id);

        return UserDTO::fromModel($user);
     }

     public function restore ($id): ?UserDTO
     {
         try {

             $user = $this->model->withTrashed()->findOfFail($id);
             $user->restore();

            return UserDTO::fromModel($user);
         } catch (ModelNotFoundException $e){
             return null;
         } catch (\Exception $e) {
             throw $e;
         }
     }

     public function forceDelete ($id)
     {
         try {
            $user = $this->model->withTrashed()->findOfFail($id);
             $result = $user->forceDelete();

            return $result;

         } catch (ModelNotFoundException $e){
             return null;
         } catch (\Exception $e) {
             throw $e;
         }
     }

}
