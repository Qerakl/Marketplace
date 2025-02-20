<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;

class ProductCategory extends Model
{
    use AsSource, HasFactory;
    protected $fillable = [
        'name',
    ];

    protected function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
