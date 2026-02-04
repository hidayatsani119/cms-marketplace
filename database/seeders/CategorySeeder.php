<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cleansers',
                'description' => 'Facial cleansers, makeup removers, and cleansing oils',
            ],
            [
                'name' => 'Serums',
                'description' => 'Concentrated treatments for specific skin concerns',
            ],
            [
                'name' => 'Moisturizers',
                'description' => 'Hydrating creams, lotions, and gels',
            ],
            [
                'name' => 'Masks',
                'description' => 'Sheet masks, clay masks, and overnight treatments',
            ],
            [
                'name' => 'Suncare',
                'description' => 'Sunscreens and sun protection products',
            ],
            [
                'name' => 'Toners',
                'description' => 'Toners, essences, and balancing treatments',
            ],
            [
                'name' => 'Eye Care',
                'description' => 'Eye creams, serums, and treatments',
            ],
            [
                'name' => 'Exfoliators',
                'description' => 'Chemical and physical exfoliating products',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Created ' . count($categories) . ' categories.');
    }
}
