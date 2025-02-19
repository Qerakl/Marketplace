<?php

namespace App\Orchid\Layouts\Product;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'products';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [];
    }
}
