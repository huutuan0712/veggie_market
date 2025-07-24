<?php

namespace App\Services;

use App\Models\Product;
use App\Models\WishList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WishlistService extends BaseService
{
    /**
     * @var WishList|Builder
     */
    protected Model|Builder $model;
    protected Product $product;

    public function __construct(WishList $model, Product $product)
    {
        $this->model = $model;
        $this->product = $product;
    }

     public function getWishlistItems()
     {
         $user = Auth::user();

         if ($user) {
             return $this->getAuthenticatedWishlist($user->id);
         } else {
             return $this->getGuestWishlist();
         }
     }

    protected function getAuthenticatedWishlist($userId)
    {
        return $this->model->with('product.images')
        ->where('user_id', $userId)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'category' => $item->product->category->name ?? 'Chưa rõ',
                    'image' => $item->product->images?->first()->path,
                    'price' => $item->product->price,
                    'originalPrice' => $item->product->original_price,
                    'status' => $item->product->status,
                    'description' => $item->product->description,
                    'origin' => $item->product->origin,
                    'quantity' => $item->quantity,
                ];
            })->toArray();
    }

    /**
     * Wishlist cho user chưa login (Session).
     */
    protected function getGuestWishlist()
    {
        $wishlist = session('wishlist', []);
        $productIds = array_keys($wishlist);

        $products = $this->product->with(['images','category'])
            ->whereIn('id', $productIds)
            ->get()
            ->map(function ($product) use ($wishlist) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category->name ?? 'Chưa rõ',
                    'image' => $product->images->first()?->path,
                    'price' => $product->price,
                    'originalPrice' => $product->original_price,
                    'status' => $product->status,
                    'description' => $product->description,
                    'origin' => $product->origin,
                    'quantity' => $wishlist[$product->id]['quantity'] ?? 1,
                ];
            })->toArray();

        return $products;
    }

     public function toggle($productId)
     {
         if (!Auth::check()) {
             $wishlist = session()->get('wishlist', []);
             if (isset($wishlist[$productId])) {
                 unset($wishlist[$productId]);
                 $message = 'Đã xóa khỏi danh sách yêu thích.';
             } else {
                 $wishlist[$productId] = ['quantity' => 1];
                 $message = 'Đã thêm vào danh sách yêu thích.';
             }
             session()->put('wishlist', $wishlist);
             $count = count($wishlist);
         } else {
             $wishlist = Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->first();
             if ($wishlist) {
                 $wishlist->delete();
                 $message = 'Đã xóa khỏi danh sách yêu thích.';
             } else {
                 Wishlist::create([
                     'user_id' => Auth::id(),
                     'product_id' => $productId,
                     'quantity' => 1,
                 ]);
                 $message = 'Đã thêm vào danh sách yêu thích.';
             }
             $count = Wishlist::where('user_id', Auth::id())->count();
         }

         return [
             'message' => $message,
             'count' => $count,
         ];
     }

    /**
     * Cập nhật số lượng sản phẩm trong wishlist.
     */
    public function updateQuantity($productId, $quantity)
    {
        if (Auth::check()) {
            Wishlist::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                ],
                [
                    'quantity' => $quantity,
                ]
            );
            $message = 'Cập nhật số lượng thành công!';
        } else {
            $wishlist = session()->get('wishlist', []);
            $wishlist[$productId] = [
                'product_id' => $productId,
                'quantity' => $quantity,
            ];
            session()->put('wishlist', $wishlist);
            $message = 'Đã lưu số lượng vào session (chưa đăng nhập)';
        }

        return ['message' => $message];
    }

    public function destroy($productId)
    {
        if (Auth::check()) {
            Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->delete();
            $count = Wishlist::where('user_id', Auth::id())->count();
        } else {
            $wishlist = session()->get('wishlist', []);
            unset($wishlist[$productId]);
            session()->put('wishlist', $wishlist);
            $count = count($wishlist);
        }

        return [
            'message' => 'Đã xoá sản phẩm',
            'count' => $count,
        ];
    }
}
