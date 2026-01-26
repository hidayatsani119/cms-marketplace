<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Enum\ProductStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->string('name',100)->nullable(false);
            $table->string('description',100)->nullable(false);
            $table->integer('price')->nullable(false);
            $table->integer('quantity')->nullable(false);
            $table->string('image_path'  )->nullable();
            $table->enum('status',['active','inactive'])->default(ProductStatusEnum::ACTIVE);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
