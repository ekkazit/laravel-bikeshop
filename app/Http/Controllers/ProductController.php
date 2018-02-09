<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use Input, Config, Validator, Image;

class ProductController extends Controller
{
    // default rp
    var $rp = 10;
    
    public function __construct() {
        // get config from app.php
        $this->rp = Config::get('app.result_per_page');
    }

    public function index() {
        $products = Product::paginate($this->rp);
        return view('product/index', compact('products'));
    }

    public function search() {
        $query = Input::get('q');

        if($query) {
            $products = Product::where('code', 'like', '%'.$query.'%')
                ->orWhere('name', 'like', '%'.$query.'%')
                ->paginate($this->rp);
        } else {
            $products = Product::paginate($this->rp);
        }

        return view('product/index', compact('products'));
    }

    public function edit($id = null) {
        $categories = Category::pluck('name', 'id')->prepend('เลือกรายการ', '');

        if($id) {
            // edit view
            $product = Product::where('id', $id)->first();
            return view('product/edit')
                ->with('product', $product)
                ->with('categories', $categories);
        } else {
            // add view
            return view('product/add')
                ->with('categories', $categories);
        }
    }

    public function update() {

        $rules = array(
            'code' => 'required',
            'name' => 'required',
            'category_id' => 'required|numeric',
            'price' => 'numeric',
            'stock_qty' => 'numeric',
        );
        
        $messages = array(
            'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน',
            'numeric' => 'กรุณากรอกข้อมูล :attribute ให้เป็นตัวเลข',
        );
        
        $id = Input::get('id');

        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('product/edit/'.$id)
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::find($id);
        $product->code = Input::get('code');
        $product->name = Input::get('name');
        $product->category_id = Input::get('category_id');
        $product->price = Input::get('price');
        $product->stock_qty = Input::get('stock_qty');
        $product->save();

        if(Input::hasFile('image'))
        {
            $f = Input::file('image');
            $upload_to = 'upload/images';

            $relative_path = $upload_to.'/'.$f->getClientOriginalName();
            $absolute_path = public_path().'/'.$upload_to;

            $f->move($absolute_path, $f->getClientOriginalName());
            $product->image_url = $relative_path;
            $product->save();
            
            // Image resize
            Image::make(public_path().'/'.$relative_path)->resize(200, 200)->save();
        }

        return redirect('product')
            ->with('ok', true)
            ->with('msg', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }


    public function insert() {
        $rules = array(
            'code' => 'required',
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'numeric',
            'stock_qty' => 'numeric',
            'image' => 'max:100000',
        );
        
        $messages = array(
            'required' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน',
            'numeric' => 'กรุณากรอกข้อมูล :attribute ให้เป็นตัวเลข',
            'uploaded' => 'กรุณาเลือกไฟล์ :attribute ไม่เกิน 100k',
        );
        
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('product/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $product = new Product();
        $product->code = Input::get('code');
        $product->name = Input::get('name');
        $product->category_id = Input::get('category_id');
        $product->price = Input::get('price');
        $product->stock_qty = Input::get('stock_qty');
        $product->save();

        if(Input::hasFile('image'))
        {
            // file upload
            $f = Input::file('image');
            $relative_path = 'upload/images/'.$f->getClientOriginalName();
            $f->move(public_path().'/'.'upload/images', $f->getClientOriginalName());
            $product->image_url = $relative_path;
            
            // Image resize
            Image::make(public_path().'/'.$relative_path)->resize(200, 250)->save();
            $product->save();
        }

        return redirect('product')
            ->with('ok', true)
            ->with('msg', 'เพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function remove($id) {
        Product::find($id)->delete();
        return redirect('product')
            ->with('ok', true)
            ->with('msg', 'ลบข้อมูลสำเร็จ');
    }

}
