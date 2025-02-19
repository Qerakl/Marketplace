<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
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
