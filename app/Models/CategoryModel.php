<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $fillable = ['name'];

    public function product()
    {
        return $this->hasMany(ProductModel::class);
    }
}
