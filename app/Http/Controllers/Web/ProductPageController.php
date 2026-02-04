<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductPageController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('landing.products', compact('categories'));
    }

    public function show(int $id)
    {
        $product = Product::with('category')->find($id);
        
        if (!$product) {
            return redirect('/products')->with('error', 'Product not found');
        }

        return view('landing.product-detail', compact('product'));
    }
}

