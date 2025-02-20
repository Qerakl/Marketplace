<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class Product extends Model
{
    use AsSource;
    protected $fillable = [
      'name',
      'category_id',
      'description',
      'price',
      'image',
    ];

    protected function category(): BelongsTo
    {
        return $this->BelongsTo(ProductCategory::class, 'category_id', 'id');
    }
}
