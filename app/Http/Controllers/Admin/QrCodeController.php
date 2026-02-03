<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_qr_code;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function index()
    {
        $qrCodes = Product_qr_code::with('product')->latest()->paginate(10);

        return view('admin.qr-codes.index', compact('qrCodes'));
    }

    public function store(Product $product)
    {
        // Check if QR code already exists
        if ($product->product_qr_code) {
            return redirect()->back()->with('error', 'QR code already exists for this product');
        }

        $token = Str::uuid()->toString();
        $filename = "qr-codes/{$token}.png";

        // Generate QR code
        $qrCode = QrCode::format('png')
            ->size(300)
            ->margin(2)
            ->generate(config('app.url') . "/verify/{$token}");

        Storage::disk('public')->put($filename, $qrCode);

        Product_qr_code::create([
            'product_id' => $product->id,
            'qr_token' => $token,
            'qr_image_path' => $filename,
        ]);

        return redirect()->back()->with('success', 'QR code generated successfully');
    }

    public function destroy(Product_qr_code $qrCode)
    {
        if ($qrCode->qr_image_path) {
            Storage::disk('public')->delete($qrCode->qr_image_path);
        }

        $qrCode->delete();

        return redirect()->route('admin.qr-codes.index')->with('success', 'QR code deleted successfully');
    }
}
