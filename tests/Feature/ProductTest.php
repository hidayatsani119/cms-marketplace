<?php

namespace Tests\Feature;

use App\Enum\ProductStatusEnum;
use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testCreateProduct()
    {
        $this->seed(UserSeeder::class);
        $response = $this->withHeader('Authorization','testToken')->post('/api/products', [
           'name' => 'test product',
           'description' => 'test product',
           'price' => 100,
           'quantity' => 10,
        ]);

        $response->assertStatus(201)->assertJson([
        "message" => "Product created successfully",
        "data" => [
            "name" => "test product",
            "description" => "test product",
            "price" => 100,
            "quantity" => 10,
            "image_path" => null
            ]
         ]);
        dump($response->json());
    }

    public  function testCreateProductWithImage()
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('image.jpg', 100);

        $payload = [
            'name' => 'test product',
            'description' => 'test product',
            'price' => 100,
            'quantity' => 10,
            'image' => $image,
        ];
        $this->seed(UserSeeder::class);
        $response = $this->withHeader('Authorization','testToken')
            ->post('/api/products', $payload);

        $response->assertStatus(201)->assertJson([
            "message" => "Product created successfully",
            "data" => [
                "name" => "test product",
                "description" => "test product",
                "price" => 100,
                "quantity" => 10,
            ]
        ]);
        self::assertNotNull($response->json(['data'])['image_path']);

        dump($response->json());
    }

    public function testgetAllProduct(){
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);
        $response = $this->get('/api/products');
        dump($response->json());
        $response->assertStatus(200)->assertJson([
            "message" => "Products retrieved successfully",
        ]);

        self::assertEquals(2, count($response->json()['data']));
    }

    public function testGetProduct()
    {
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);

        $product = Product::where('name', 'test product 2')->first();
        $response = $this->get("/api/products/{$product->id}");
        dump($response->json());

        $response->assertStatus(200)->assertJson([
            "message" => "Product retrieved successfully",
            'data' => [
                'name' => 'test product 2',
                'description' => 'test product 2',
                'price' => 100,
                'quantity' => 10,
            ]
        ]);
        self::assertEquals(9, count($response->json()['data']));
    }

    public function testUpdateProduct()
    {
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);

        $product = Product::where('name', 'test product 2')->first();
        $response = $this->withHeader('Authorization','testToken')
            ->put("/api/products/{$product->id}",
            [
                'name' => 'new test product 2',
                'description' => 'new test product 2',
                'price' => 200,
                'quantity' => 20,
                'status' => ProductStatusEnum::INACTIVE->value,
            ]);
        dump($response->json());

        $response->assertStatus(200)->assertJson([
            "message" => "Product updated successfully",
            'data' => [
                'name' => 'new test product 2',
                'description' => 'new test product 2',
                'price' => 200,
                'quantity' => 20,
                'status' => ProductStatusEnum::INACTIVE->value,
            ]
        ]);

    }

    public function testUpdateProductWithImage ()
    {
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);

        $product = Product::where('name', 'test product 2')->first();

        Storage::fake('public');

        $image = UploadedFile::fake()->image('image.jpg', 100);

        $payload = [
            'name' => 'new test product 2',
            'description' => 'new test product 2',
            'price' => 200,
            'quantity' => 20,
            'image' => $image,
            'status' => ProductStatusEnum::INACTIVE->value,
        ];
        $response = $this->withHeader('Authorization','testToken')
            ->put("/api/products/{$product->id}",$payload);
        dump($response->json());

        $response->assertStatus(200)->assertJson([
            "message" => "Product updated successfully",
            'data' => [
                'name' => 'new test product 2',
                'description' => 'new test product 2',
                'price' => 200,
                'quantity' => 20,
                'status' => ProductStatusEnum::INACTIVE->value,
            ]
        ]);

        self::assertNotEquals($product->image_path, $response->json()['data']['image_path']);
    }

    public function testDeleteProduct()
    {
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);

        $product = Product::where('name', 'test product 2')->first();

        $response = $this->withHeader('Authorization','testToken')
            ->delete("/api/products/{$product->id}");
        dump($response->json());

        $response->assertStatus(200)->assertJson([
            "message" => "Product deleted successfully",
            'data' => null
        ]);

    }
}
