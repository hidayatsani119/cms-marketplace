<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductQrCodeResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Product_qr_code;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use function Laravel\Prompts\select;

class ProductQrCodeController extends Controller
{
    public function create(Request $request) : JsonResponse
    {
        $products_id = $request->route('product_id');
        $product = Product::where('id', $products_id)->first();

        if (!$product) {
            throw new HttpResponseException(response()->json([
                'errors' => 'Product not found.',
            ],404));
        }

        $qr_token = Str::uuid()->toString();
        $qrUrl = 'http://127.0.0.1:8000/' . 'verify/' . $qr_token;
        $filePath = 'products/qr/' . $qr_token . '.png';

        $qrImage = QrCode::format('png')->size( 400)->generate($qrUrl);

        Storage::disk('public')->put($filePath, $qrImage);
        $product_qr_code = Product_qr_code::create([
            'product_id' => $product->id,
            'qr_token' => $qr_token,
            'qr_image_path' => $filePath,
        ]);

        return response()->json([
            'message' => 'QR Code Generated Successfully.',
            'data' => new ProductQrCodeResource($product_qr_code),
        ],201);
    }

    public function verify(Request $request) : JsonResponse
    {
        $qr_token = $request->route('qr_token');
        $id_product = Product_qr_code::where('qr_token', $qr_token)->select('product_id')->first();
        if (!$id_product) {
            throw new HttpResponseException(response()->json([
                'errors' => 'QR Code Not Found.',
            ],404));
        }
        $product = Product::where('id', $id_product->product_id)->first();

        if (!$product) {
            throw new HttpResponseException(response()->json([
                'errors' => 'QR Code Not Found.',
            ],404));
        }
        return response()->json([
            'message' => 'QR Code Verified Successfully.',
            'data' => new ProductResource($product),
        ]);

    }
}
