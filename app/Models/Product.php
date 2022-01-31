<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [

        'product_name',
        'product_desc',
        'product_price',
        'sale_price',
        'quantity',
        'image',
        'image1',
        'image2',
        'category_id',
    ];

    public function Category(){
        return $this->belongsTo(Category::class);
    }


}
