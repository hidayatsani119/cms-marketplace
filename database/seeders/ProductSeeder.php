<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    private array $productPrefixes = [
        'Advanced', 'Premium', 'Ultra', 'Intense', 'Gentle', 'Daily',
        'Pro', 'Natural', 'Organic', 'Clinical', 'Luxury', 'Essential',
    ];

    private array $productTypes = [
        'Serum' => 'skincare serum',
        'Cream' => 'face cream',
        'Cleanser' => 'facial cleanser',
        'Toner' => 'face toner',
        'Moisturizer' => 'moisturizer',
        'Mask' => 'face mask',
        'Oil' => 'facial oil',
        'Essence' => 'skin essence',
        'Lotion' => 'body lotion',
        'Mist' => 'face mist',
    ];

    private array $ingredients = [
        'Vitamin E', 'Green Tea', 'Aloe Vera', 'Collagen', 'Snail Mucin',
        'Tea Tree', 'Charcoal', 'Glycolic Acid', 'Lactic Acid', 'Squalane',
        'Bakuchiol', 'Azelaic Acid', 'Zinc', 'Arbutin', 'Licorice Root',
        'Turmeric', 'Propolis', 'Honey', 'Avocado', 'Jojoba',
    ];

    private array $unsplashImages = [
        'photo-1556228720-195a672e8a03', 'photo-1620916566398-39f1143ab7be',
        'photo-1570194065650-d99fb4b38b15', 'photo-1608248597279-f99d160bfcbc',
        'photo-1611930022073-b7a4ba5fcccd', 'photo-1617897903246-719f41cb92c6',
        'photo-1556227702-d1e4e7b5c232', 'photo-1598440947619-2c35fc9aa908',
        'photo-1612817288484-6f916006741a', 'photo-1596755389378-c31d21fd1273',
        'photo-1608571423902-eed4a5ad8108', 'photo-1567721913486-6585f069b332',
        'photo-1619451334792-150fd785ee74', 'photo-1631729371254-42c2892f0e6e',
        'photo-1601049541289-9b1b7bbbfe19', 'photo-1556228578-8c89e6adf883',
    ];

    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            $this->command->error('No user found. Please create a user first.');
            return;
        }

        $categoryIds = \App\Models\Category::pluck('id')->toArray();
        
        if (empty($categoryIds)) {
            $this->command->error('No categories found. Please run CategorySeeder first.');
            return;
        }

        $products = $this->getBaseProducts();
        $dynamicProducts = $this->generateDynamicProducts(38);
        $allProducts = array_merge($products, $dynamicProducts);

        foreach ($allProducts as $productData) {
            $imagePath = $this->downloadImage($productData['image']);
            
            Product::create([
                'user_id' => $user->id,
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'quantity' => $productData['quantity'],
                'image_path' => $imagePath,
                'status' => $productData['status'] ?? 'active',
            ]);
        }

        $this->command->info('Created ' . count($allProducts) . ' skincare products.');
    }

    private function generateDynamicProducts(int $count): array
    {
        $products = [];
        
        for ($i = 0; $i < $count; $i++) {
            $prefix = $this->productPrefixes[array_rand($this->productPrefixes)];
            $type = array_rand($this->productTypes);
            $ingredient = $this->ingredients[array_rand($this->ingredients)];
            $image = $this->unsplashImages[array_rand($this->unsplashImages)];
            
            $products[] = [
                'name' => "{$prefix} {$ingredient} {$type}",
                'description' => $this->generateDescription($ingredient, $type),
                'price' => rand(5, 50) * 10000,
                'quantity' => rand(10, 100),
                'image' => "https://images.unsplash.com/{$image}?w=800&q=80",
                'status' => rand(1, 10) > 2 ? 'active' : 'inactive',
            ];
        }
        
        return $products;
    }

    private function generateDescription(string $ingredient, string $type): string
    {
        $benefits = [
            'Hydrates and nourishes skin for a healthy glow.',
            'Helps reduce the appearance of fine lines and wrinkles.',
            'Brightens and evens out skin tone.',
            'Soothes and calms irritated skin.',
            'Controls oil production and minimizes pores.',
            'Provides deep cleansing and removes impurities.',
            'Boosts skin elasticity and firmness.',
            'Protects against environmental stressors.',
        ];
        
        $benefit = $benefits[array_rand($benefits)];
        $typeDesc = $this->productTypes[$type];
        
        return "Premium {$typeDesc} enriched with {$ingredient}. {$benefit} " .
               "Suitable for all skin types. Dermatologically tested.";
    }

    private function getBaseProducts(): array
    {
        return [
            [
                'name' => 'Hydrating Facial Cleanser',
                'description' => 'Gentle foaming cleanser with hyaluronic acid and ceramides.',
                'price' => 189000,
                'quantity' => 50,
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=800&q=80',
            ],
            [
                'name' => 'Vitamin C Brightening Serum',
                'description' => '15% Vitamin C serum to brighten skin and boost collagen.',
                'price' => 349000,
                'quantity' => 35,
                'image' => 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=800&q=80',
            ],
            [
                'name' => 'Retinol Night Cream',
                'description' => 'Anti-aging night cream with encapsulated retinol.',
                'price' => 425000,
                'quantity' => 28,
                'image' => 'https://images.unsplash.com/photo-1570194065650-d99fb4b38b15?w=800&q=80',
            ],
            [
                'name' => 'Niacinamide Pore Minimizer',
                'description' => '10% Niacinamide serum for pore control and skin texture.',
                'price' => 275000,
                'quantity' => 42,
                'image' => 'https://images.unsplash.com/photo-1608248597279-f99d160bfcbc?w=800&q=80',
            ],
            [
                'name' => 'Hyaluronic Acid Moisturizer',
                'description' => 'Triple molecular weight HA for 72-hour hydration.',
                'price' => 299000,
                'quantity' => 55,
                'image' => 'https://images.unsplash.com/photo-1611930022073-b7a4ba5fcccd?w=800&q=80',
            ],
            [
                'name' => 'Salicylic Acid Spot Treatment',
                'description' => '2% Salicylic acid gel for acne-prone skin.',
                'price' => 159000,
                'quantity' => 60,
                'image' => 'https://images.unsplash.com/photo-1617897903246-719f41cb92c6?w=800&q=80',
            ],
            [
                'name' => 'Sunscreen SPF 50+ PA++++',
                'description' => 'Lightweight broad spectrum protection for daily use.',
                'price' => 245000,
                'quantity' => 70,
                'image' => 'https://images.unsplash.com/photo-1556227702-d1e4e7b5c232?w=800&q=80',
            ],
            [
                'name' => 'Exfoliating Toner AHA/BHA',
                'description' => 'Gentle exfoliating toner for smoother complexion.',
                'price' => 225000,
                'quantity' => 45,
                'image' => 'https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?w=800&q=80',
            ],
            [
                'name' => 'Peptide Eye Cream',
                'description' => 'Peptides and caffeine for dark circles and puffiness.',
                'price' => 375000,
                'quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1612817288484-6f916006741a?w=800&q=80',
            ],
            [
                'name' => 'Centella Calming Mask',
                'description' => 'Centella Asiatica sheet mask for irritated skin.',
                'price' => 35000,
                'quantity' => 100,
                'image' => 'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?w=800&q=80',
            ],
            [
                'name' => 'Rose Hip Facial Oil',
                'description' => 'Cold-pressed rosehip oil for nourishment and scars.',
                'price' => 285000,
                'quantity' => 32,
                'image' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=800&q=80',
            ],
            [
                'name' => 'Clay Purifying Mask',
                'description' => 'Kaolin and bentonite clay for deep cleansing.',
                'price' => 195000,
                'quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1567721913486-6585f069b332?w=800&q=80',
            ],
        ];
    }

    private function downloadImage(string $url): ?string
    {
        try {
            $contents = file_get_contents($url);
            $filename = 'products/' . Str::uuid() . '.jpg';
            Storage::disk('public')->put($filename, $contents);
            return $filename;
        } catch (\Exception $e) {
            return null;
        }
    }
}
