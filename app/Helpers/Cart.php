<?php

namespace App\Helpers;

use App\Product;
use Session;

class Cart {
    public function getCartItems() {
        return Session::get('cart_items');
    }

    public function updateCart($id, $qty) {
        $cart_items = Session::get('cart_items');
        $cart_items[$id]['qty'] = $qty;
        Session::put('cart_items', $cart_items);
    }

    public function deleteCart($id) {
        $cart_items = Session::get('cart_items');
        unset($cart_items[$id]);
        Session::put('cart_items', $cart_items);
    } 

    public function addToCart($id) {
        $product = Product::find($id);

        $cart_items = Session::get('cart_items');
        if(is_null($cart_items)) {
            $cart_items = array();
        }

        $qty = 0;
        if(array_key_exists($product->id, $cart_items)) {
            $qty = $cart_items[$product->id]['qty'];
        }
        
        $cart_items[$product['id']] = array(
            'id' => $product->id,
            'code' => $product->code,
            'name' => $product->name,
            'price' => $product->price,
            'image_url' => $product->image_url,
            'qty' => $qty + 1,
        );
        Session::put('cart_items', $cart_items);
    }
}
