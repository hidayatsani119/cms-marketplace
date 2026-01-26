<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Product_qr_code;
use Database\Seeders\ProductSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProductQrCodeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateProductQrCode()
    {
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);
        $product = Product::where('name', 'test product')->first();

        $response = $this->withHeader('Authorization','testToken')
            ->post("/api/products/{$product->id}/qr-code");

        $response->assertStatus(201)->assertJson([
            'message' => "QR Code Generated Successfully.",
        ]);
        dump($response->json());
    }

    public function testVerifyProductQrCode()
    {
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);

        $product = Product::where('name', 'test product')->first();

        $this->withHeader('Authorization','testToken')
            ->post("/api/products/{$product->id}/qr-code");

        $qr = Product_qr_code::where('product_id', $product->id)->first();

        $response = $this->post("/api/qr/{$qr->qr_token}");
        $response->assertStatus(200);
        dump($qr->qr_token);
        dump($response->json());

    }

    public function testVerifyProductQrCodeFails()
    {
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);

        $product = Product::where('name', 'test product')->first();

        $this->withHeader('Authorization','testToken')
            ->post("/api/products/{$product->id}/qr-code");

        $qr = Product_qr_code::where('product_id', $product->id)->first();

        $response = $this->post("/api/qr/8877a9a2-f280-4999-87df-cf8612b86567");



        $response->assertStatus(404)->assertJson([
            'errors' => "QR Code Not Found.",
        ]);
    }
}
