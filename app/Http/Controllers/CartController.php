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

    public function checkout() {
        $cart_items = Session::get('cart_items');
        return view('cart/checkout', compact('cart_items'));
    }

    public function view_po() {
        $cart_items = Session::get('cart_items');
        $cust_name = Input::get('cust_name');
        $cust_email = Input::get('cust_email');
        $po_no = 'PO'.date("Ymd");
        $po_date = date("Y-m-d H:i:s");
        $total_amount = 0;

        foreach($cart_items as $c) {
            $total_amount += $c['price'] * $c['qty'];       
        }

        return view('cart/complete', compact('cart_items', 'cust_name', 'cust_email', 'po_no', 'po_date', 'total_amount'));
    }

    public function complete() {
        $cart_items = Session::get('cart_items');
        $cust_name = Input::get('cust_name');
        $cust_email = Input::get('cust_email');
        $po_no = 'PO'.date("Ymd");
        $po_date = date("Y-m-d H:i:s");
        $total_amount = 0;

        foreach($cart_items as $c) {
            $total_amount += $c['price'] * $c['qty'];       
        }

        $html_output = view('cart/complete', compact('cart_items', 'cust_name', 'cust_email', 'po_no', 'po_date', 'total_amount'))->render();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->debug = true; 
        $mpdf->WriteHTML($html_output);
        $mpdf->Output('output.pdf', 'I');
        return $resp->withHeader("Content-type", "application/pdf");
    }

    public function finish_order() {
        // save order to data
        $cart_items = Session::get('cart_items');
        // save order to data
        Session::remove('cart_items');
        return redirect('/');
    }
}
