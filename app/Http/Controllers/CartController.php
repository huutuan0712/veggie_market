<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddCartRequest;
use App\Http\Responses\ApiResponse;
use App\DTOs\Cart\CartItem as CartItemDTO;
use Illuminate\Http\Request;
use App\Services\CartItemService;

class CartController extends Controller
{
    public function __construct(
        protected CartItemService $cartItemService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->cartItemService->getCartItemsAndTotal();

        return view('pages.cart.index', $data);
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
    public function store(AddCartRequest $request)
    {
        $dto = CartITemDTO::fromRequest($request->validated());
        $result =$this->cartItemService->addToCart($dto);

        return ApiResponse::success(
            'Sản phẩm đã được thêm vào giỏ hàng.',
            $result,
            null,
            200
        )->toResponse();
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
    public function update(Request $request, string $id)
    {
        $quantity = (int) $request->input('quantity');
        $result = $this->cartItemService->updateCartQuantity($id, $quantity);
        return ApiResponse::success(
            'Cập nhật giỏ hàng thành công.',
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
        $result = $this->cartItemService->deleteCart($id);
        return ApiResponse::success(
            'Đã xoá sản phẩm',
            $result,
            null,
            200
        )->toResponse();
    }

}
