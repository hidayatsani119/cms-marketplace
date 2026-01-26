<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::where('email','admin@mail.com')->first();
        Product::create([
            'user_id' => $user->id,
            'name' => 'test product',
            'description' => 'test product',
            'price' => 100,
            'quantity' => 10,
        ]);

        Product::create([
            'user_id' => $user->id,
            'name' => 'test product 2',
            'description' => 'test product 2',
            'price' => 100,
            'quantity' => 10,
        ]);
    }
}
