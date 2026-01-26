<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product_qr_code extends Model
{
    protected $table = 'product_qr_codes';
    protected $primaryKey ='id';
    protected $keyType ='int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'product_id',
        'qr_token',
        'qr_image_path',
    ];

    protected $appends = ['qr_image_url'];

    public function getQrImageUrlAttribute()
    {
        return "http://127.0.0.1:8000" . Storage::url($this->qr_image_path);
    }

    protected static function booted()
    {
        static::deleting(function ($product) {
            if($product->image_path){
                Storage::disk('public')->delete($product->image_path);
            }
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
