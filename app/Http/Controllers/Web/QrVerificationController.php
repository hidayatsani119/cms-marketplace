<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrVerificationController extends Controller
{
    public function index()
    {
        return view('landing.verify-qr');
    }

    public function verify(string $token)
    {
        return view('landing.verify-qr', ['token' => $token]);
    }
}
