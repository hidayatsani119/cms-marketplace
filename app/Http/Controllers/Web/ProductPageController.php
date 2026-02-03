<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductPageController extends Controller
{
    public function index()
    {
        return view('landing.products');
    }

    public function show(int $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return redirect('/products')->with('error', 'Product not found');
        }

        return view('landing.product-detail', compact('product'));
    }
}
