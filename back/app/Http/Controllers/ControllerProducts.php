<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ControllerProducts extends Controller
{
    function all()
    {
        return Product::all();
    }

    function add(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->save();
        return $product;
    }

    function del($id)
    {
       $user = Product::find($id);
       $user->delete();
    }

    function edit($id, Request $request)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->save();
        return $product;
    }
}
