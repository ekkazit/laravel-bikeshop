<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use Session, Input, Cart;

class CartController extends Controller
{
    public function viewCart() {
        $cart_items = Cart::getCartItems();
        return view('cart/index', compact('cart_items'));
    }

    public function addToCart($id) {
        Cart::addToCart($id);
        return redirect('cart/view');
    }

    public function deleteCart($id) {
        Cart::deleteCart($id);
        return redirect('cart/view');
    }

    public function updateCart($id, $qty) {
        Cart::updateCart($id, $qty);
        return redirect('cart/view');
    }
}
