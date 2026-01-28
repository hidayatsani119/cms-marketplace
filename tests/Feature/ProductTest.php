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
use function PHPUnit\Framework\assertEquals;

class ProductTest extends TestCase
{
    //success test-case
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


    }

    public function testgetAllProduct(){
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);
        $response = $this->get('/api/products');

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


        $response->assertStatus(200)->assertJson([
            "message" => "Product deleted successfully",
            'data' => null
        ]);

    }

    public function testSearchProductOrderByPrice()
    {
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);

         $responseHighest = $this->get('/api/products/search?price=highest')->assertStatus(200)->assertJson([
            "message" => "Products retrieved successfully",
        ]);

        assertEquals(200, $responseHighest->json()['data'][0]['price']);
        assertEquals(100, $responseHighest->json()['data'][1]['price']);

        $responseLowest = $this->get('/api/products/search?price=lowest')->assertStatus(200)->assertJson([
            "message" => "Products retrieved successfully",
        ]);
        assertEquals(100, $responseLowest->json()['data'][0]['price']);
        assertEquals(200, $responseLowest->json()['data'][1]['price']);
    }
    public function testSearchProductOrderByNewestAndOldest()
    {
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);

       $responseLatest = $this->get('/api/products/search?order=latest')->assertStatus(200)->assertJson([
           "message" => "Products retrieved successfully",
       ]);

        $responseNewest = $this->get('/api/products/search?order=newest')->assertStatus(200)->assertJson([
            "message" => "Products retrieved successfully",
        ]);

        self::assertLessThan($responseLatest->json()['data'][1]['id'] ,$responseLatest->json()['data'][0]['id']);
        self::assertGreaterThan($responseNewest->json()['data'][1]['id'] ,$responseNewest->json()['data'][0]['id']);
    }
    public function testSearchProductName()
    {
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);

        $response = $this->get('/api/products/search?name=test product 2')->assertStatus(200)->assertJson([
            "message" => "Products retrieved successfully",
        ]);

        $response->assertStatus(200)->assertJson([
            "message" => "Products retrieved successfully",
            "data" => [
              [  "name" => "test product 2",
                "description" => "test product 2",
                "price" => 100,
                "quantity" => 10,
                "image_path" => null,
                "image_url" => "http://localhost/storage/",
                "status" => "active",]
            ]
        ]);


    }

    //fail test-case
    public function testProductNotFound()
    {
        $this->seed(UserSeeder::class);
        $this->get('/api/products')->assertStatus(404)->assertJson([
            "errors" => "Product not found"
        ]);

        $this->seed(ProductSeeder::class);

        $this->get("/api/products/10")->assertStatus(404)->assertJson([
            "errors" => "Product not found"
        ]);;
    }

    public function testCreateProductFailValidationError()
    {
        $this->seed(UserSeeder::class);
        $response = $this->withHeader('Authorization','testToken')->post('/api/products', [
            'name' => 'test product',
            'description' => 'test product',
            'price' => 0,
            'quantity' => -1,
        ]);

        $response->assertStatus(400)->assertJson([
            "errors" => [
               'price' => [
                   "The price field must be greater than 0."
               ],
                'quantity' => [
                    'The quantity field must be greater than or equal to 0.'
                ]
            ]

        ]);
    }

    public function testAllProtectedProductsEndpointFailAuthError()
    {
        $this->seed(UserSeeder::class);
        $this->withHeader('Authorization','wrongToken')->post('/api/products', [
            'name' => 'test product',
            'description' => 'test product',
            'price' => 100,
            'quantity' => 10,
        ])->assertStatus(401)->assertJson([
            "errors" => "Unauthorized."
        ]);


        $this->seed(ProductSeeder::class);

        $product = Product::where('name', 'test product 2')->first();
        $this->withHeader('Authorization','wrongToken')
            ->put("/api/products/{$product->id}",
                [
                    'name' => 'new test product 2',
                    'description' => 'new test product 2',
                    'price' => 200,
                    'quantity' => 20,
                    'status' => ProductStatusEnum::INACTIVE->value,
                    ])->assertStatus(401)->assertJson([
                        "errors" => "Unauthorized."
            ]);

        $this->withHeader('Authorization','wrongToken')
            ->delete("/api/products/{$product->id}")->assertStatus(401)->assertJson([
            "errors" => "Unauthorized."
        ]);
    }

    public function testProductTestFailProductNotFound()
    {
        $this->seed(UserSeeder::class);
        $this->seed(ProductSeeder::class);
        $this->get('/api/products/search?name=bla bla bla')->assertStatus(404)->assertJson([
            "errors" => "Product not found"
        ]);


    }
}

