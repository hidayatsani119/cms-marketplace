<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            $this->command->error('No user found. Please create a user first.');
            return;
        }

        $products = [
            [
                'name' => 'Hydrating Facial Cleanser',
                'description' => 'Gentle foaming cleanser that removes impurities while maintaining skin\'s natural moisture barrier. Enriched with hyaluronic acid and ceramides.',
                'price' => 189000,
                'quantity' => 50,
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=800&q=80',
            ],
            [
                'name' => 'Vitamin C Brightening Serum',
                'description' => 'Powerful antioxidant serum with 15% Vitamin C to brighten skin tone, reduce dark spots, and boost collagen production.',
                'price' => 349000,
                'quantity' => 35,
                'image' => 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=800&q=80',
            ],
            [
                'name' => 'Retinol Night Cream',
                'description' => 'Anti-aging night cream with encapsulated retinol. Reduces fine lines and wrinkles while you sleep. Gentle formula suitable for sensitive skin.',
                'price' => 425000,
                'quantity' => 28,
                'image' => 'https://images.unsplash.com/photo-1570194065650-d99fb4b38b15?w=800&q=80',
            ],
            [
                'name' => 'Niacinamide Pore Minimizer',
                'description' => '10% Niacinamide serum that minimizes pores, controls oil production, and improves skin texture. Lightweight and fast-absorbing.',
                'price' => 275000,
                'quantity' => 42,
                'image' => 'https://images.unsplash.com/photo-1608248597279-f99d160bfcbc?w=800&q=80',
            ],
            [
                'name' => 'Hyaluronic Acid Moisturizer',
                'description' => 'Deeply hydrating moisturizer with triple molecular weight hyaluronic acid. Provides 72-hour hydration for plump, dewy skin.',
                'price' => 299000,
                'quantity' => 55,
                'image' => 'https://images.unsplash.com/photo-1611930022073-b7a4ba5fcccd?w=800&q=80',
            ],
            [
                'name' => 'Salicylic Acid Spot Treatment',
                'description' => '2% Salicylic acid treatment gel for acne-prone skin. Targets blemishes and prevents breakouts without over-drying.',
                'price' => 159000,
                'quantity' => 60,
                'image' => 'https://images.unsplash.com/photo-1617897903246-719f41cb92c6?w=800&q=80',
            ],
            [
                'name' => 'Sunscreen SPF 50+ PA++++',
                'description' => 'Lightweight, non-greasy sunscreen with broad spectrum protection. Water-resistant formula perfect for daily use under makeup.',
                'price' => 245000,
                'quantity' => 70,
                'image' => 'https://images.unsplash.com/photo-1556227702-d1e4e7b5c232?w=800&q=80',
            ],
            [
                'name' => 'Exfoliating Toner AHA/BHA',
                'description' => 'Gentle exfoliating toner with AHA and BHA acids. Removes dead skin cells and unclogs pores for smoother, brighter complexion.',
                'price' => 225000,
                'quantity' => 45,
                'image' => 'https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?w=800&q=80',
            ],
            [
                'name' => 'Peptide Eye Cream',
                'description' => 'Concentrated eye cream with peptides and caffeine. Reduces dark circles, puffiness, and fine lines around the delicate eye area.',
                'price' => 375000,
                'quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1612817288484-6f916006741a?w=800&q=80',
            ],
            [
                'name' => 'Centella Calming Mask',
                'description' => 'Soothing sheet mask with Centella Asiatica extract. Calms irritated skin, reduces redness, and provides intense hydration.',
                'price' => 35000,
                'quantity' => 100,
                'image' => 'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?w=800&q=80',
            ],
            [
                'name' => 'Rose Hip Facial Oil',
                'description' => 'Cold-pressed rosehip seed oil rich in vitamins A and C. Nourishes dry skin and helps fade scars and hyperpigmentation.',
                'price' => 285000,
                'quantity' => 32,
                'image' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=800&q=80',
            ],
            [
                'name' => 'Clay Purifying Mask',
                'description' => 'Deep cleansing mask with kaolin and bentonite clay. Draws out impurities and excess oil for clearer, more refined skin.',
                'price' => 195000,
                'quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1567721913486-6585f069b332?w=800&q=80',
            ],
        ];

        foreach ($products as $productData) {
            $imagePath = $this->downloadImage($productData['image']);
            
            Product::create([
                'user_id' => $user->id,
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'quantity' => $productData['quantity'],
                'image_path' => $imagePath,
                'status' => 'active',
            ]);
        }

        $this->command->info('Created ' . count($products) . ' skincare products.');
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
