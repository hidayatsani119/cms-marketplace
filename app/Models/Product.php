<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $primaryKey = 'id';
    protected $keyType ='int';
    protected $table = 'products';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'price',
        'quantity',
        'image_path',
        'status',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        $appUrl = config('app.url');
        return $appUrl.Storage::url($this->image_path);
    }

    protected static function booted()
    {
        static::deleting(function ($product) {
            if($product->image_path){
                Storage::disk('public')->delete($product->image_path);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function product_qr_code(): HasOne
    {
        return $this->hasOne(Product_qr_code::class);
    }
}

