<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $fillable = ['category_id', 'sku', 'name', 'stock', 'price', 'image'];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }
}
