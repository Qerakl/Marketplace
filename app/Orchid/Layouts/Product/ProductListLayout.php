<?php

namespace App\Orchid\Layouts\Product;

use App\Models\Product;
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
        return [
            TD::make('product_info', 'Product Information')
                ->width('350px')
                ->render(function (Product $product) {
                    $html = '<div class="d-flex align-items-center gap-3">';

                    // ID
                    $html .= '<div class="flex-shrink-0">';
                    $html .= '<span class="badge bg-primary rounded-pill px-2 py-1">';
                    $html .= '#' . $product->id;
                    $html .= '</span>';
                    $html .= '</div>';

                    // Image
                    $html .= '<div class="flex-shrink-0">';
                    if ($product->image) {
                        $html .= '<div class="position-relative">';
                        $html .= '<img src="' . e($product->image) . '" ';
                        $html .= 'alt="' . e($product->name) . '" ';
                        $html .= 'class="rounded shadow-sm" ';
                        $html .= 'style="width: 60px; height: 60px; object-fit: cover;" ';
                        $html .= 'onerror="this.src=\'/path/to/placeholder-image.jpg\'">';
                        $html .= '<div class="position-absolute top-0 start-0 translate-middle badge bg-success rounded-circle p-1">';
                        $html .= '<i class="bi bi-check"></i>';
                        $html .= '</div>';
                        $html .= '</div>';
                    } else {
                        $html .= '<div class="bg-light d-flex align-items-center justify-content-center rounded shadow-sm" ';
                        $html .= 'style="width: 60px; height: 60px;">';
                        $html .= '<i class="bi bi-image text-muted" style="font-size: 1.5rem;"></i>';
                        $html .= '</div>';
                    }
                    $html .= '</div>';

                    // Name
                    $html .= '<div class="flex-grow-1">';
                    $html .= '<span class="fw-semibold text-dark">' . e($product->name) . '</span>';
                    $html .= '</div>';

                    $html .= '</div>';

                    return $html;
                }),

            TD::make('category', 'Category')
                ->sort()
                ->render(function (Product $product) {
                    return $product->category->name;
                }),

            TD::make('price', 'Price')
                ->render(function (Product $product) {
                    return $product->price;
                }),

            TD::make('created_at', 'Created At')
                ->render(function (Product $product) {
                    return $product->created_at;
                }),
        ];
    }
}
