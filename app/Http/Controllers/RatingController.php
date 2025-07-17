<?php

namespace App\Http\Controllers;

use App\DTOs\Rating\Rating as RatingDTO;
use App\Http\Requests\Rating\StoreRatingFormRequest;
use App\Http\Requests\Rating\UpdateRatingFormRequest;
use App\Http\Responses\ApiResponse;
use App\Services\RatingService;

class RatingController extends Controller
{
    public function __construct(
        protected RatingService $ratingService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }


    public function getRatings($productId)
    {
        $result = $this->ratingService->getRatings($productId);

        return ApiResponse::success(
            'Đánh giá sản phẩm thành công.',
            $result,
            null,
            200
        )->toResponse();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRatingFormRequest $request)
    {
        $dto = RatingDTO::fromRequest($request->validated());
        $result = $this->ratingService->createDTO($dto);

        return ApiResponse::success(
            'Đánh giá sản phẩm thành công.',
            $result,
            null,
            200
        )->toResponse();
    }


    public function reply ()
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRatingFormRequest $request, $id)
    {
        $dto = RatingDTO::fromRequest($request->validated());
        $result = $this->ratingService->updateDTO($id, $dto);

        return ApiResponse::success(
            'Cập nhật đánh giá thành công.',
            $result,
            null,
            200
        )->toResponse();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->ratingService->destroy($id);

        return ApiResponse::success(
            'Xóa đánh giá thành công.',
            [
                'ratingCount'   => $result['ratingCount'],
                'averageRating' => $result['averageRating'],
            ],
            null,
            200
        )->toResponse();
    }
}
