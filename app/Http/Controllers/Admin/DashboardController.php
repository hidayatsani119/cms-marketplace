<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_qr_code;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'active')->count(),
            'total_qr_codes' => Product_qr_code::count(),
            'total_users' => User::count(),
        ];

        $recentProducts = Product::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProducts'));
    }
}
