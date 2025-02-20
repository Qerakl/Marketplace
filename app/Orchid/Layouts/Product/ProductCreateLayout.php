<?php

namespace App\Orchid\Layouts\Product;

use App\Models\ProductCategory;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ProductCreateLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title = 'Создание товара';

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('product.name')
                ->title('Название товара')
                ->type('text')
                ->required(),

            Select::make('product.category')
                ->title('Категория товара')
                ->fromModel(ProductCategory::class, 'name')
                ->required(),

            TextArea::make('product.description')
                ->title('Описание товара')
                ->required(),

            Cropper::make('product.image')
                ->title('Фото товара')
                ->minCanvas(500)
                ->maxWidth(1000)
                ->maxHeight(800),

            Input::make('product.price')
                ->title('Цена товара')
                ->type('number')
                ->required(),
        ];
    }
}
