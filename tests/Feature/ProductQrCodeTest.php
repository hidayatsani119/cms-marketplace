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
        $response->assertStatus(200)->assertJson([
            'message' => "This product is original.",
            'data' => [
                'name' => 'test product',
                'description' => 'test product',
                'price' => 200,
                'quantity' => 10,
            ]
        ]);

    }

    public function testCreateProductQrCodeFailProductNotFound()
    {
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);
        $product = Product::where('name', 'test product')->first();

        $response = $this->withHeader('Authorization','testToken')
            ->post("/api/products/10/qr-code");

        $response->assertStatus(404)->assertJson([
            'errors' => "Product not found.",
        ]);
    }

    public function testVerifyProductQrCodeFailQrProductNotFound()
    {
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);

        $product = Product::where('name', 'test product')->first();

        $this->withHeader('Authorization','testToken')
            ->post("/api/products/{$product->id}/qr-code");

        $qr = Product_qr_code::where('product_id', $product->id)->first();

        $response = $this->post("/api/qr/8877a9a2-f280-4999-87df-cf8612b86567");



        $response->assertStatus(404)->assertJson([
            'errors' => "This product is fake.",
        ]);
    }

}
