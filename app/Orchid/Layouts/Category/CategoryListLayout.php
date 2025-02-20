<?php

namespace App\Orchid\Layouts\Category;

use App\Models\ProductCategory;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'categories';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
                ->sort()
                ->render(function (ProductCategory $category) {
                    return $category->id;
                }),
            TD::make('name', 'Name')
                ->sort()
                ->render(function (ProductCategory $category) {
                    return $category->name;
                }),
        ];
    }
}
