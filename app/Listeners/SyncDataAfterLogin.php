<?php

namespace App\Listeners;

use App\Models\CartItem;
use App\Models\WishList;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SyncDataAfterLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;

        // ✅ Sync Wishlist
        if (session()->has('wishlist')) {
            foreach (session()->get('wishlist') as $productId => $data) {
                WishList::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'product_id' => $productId,
                    ],
                    [
                        'quantity' => $data['quantity'],
                    ]
                );
            }
            session()->forget('wishlist');
        }

        // ✅ Sync Cart
        if (session()->has('cart')) {
            foreach (session()->pull('cart', []) as $productId => $quantity) {
                $existing = CartItem::where('user_id', $user->id)
                    ->where('product_id', $productId)
                    ->first();

                if ($existing) {
                    $existing->increment('quantity', $quantity);
                } else {
                    CartItem::create([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                    ]);
                }
            }
        }
    }
}
