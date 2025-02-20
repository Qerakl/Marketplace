<?php

namespace App\Orchid\Screens\Product;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Orchid\Layouts\Product\ProductCreateLayout;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class ProductCreateScreen extends Screen
{
    /**
     * @var Product
     */
    public $product;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Product $product): iterable
    {
        return [
            'category' => ProductCategory::query()->pluck('name', 'id'),
            'product' => $product,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->product->exists ? 'Редактирование товара' : 'Создание товара';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать товар')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->product->exists),

            Button::make('Обновить товар')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->product->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ProductCreateLayout::class,
        ];
    }

    private function createOrUpdate(Request $request)
    {
        $data = $request->get('product');
        $path = $request->file('product.image')->store('products');
        $data['product.image'] = $path;
        $this->product->fill($data)->save();

        Alert::info('Вы успешно создали товар ' . $this->product->name);

        return redirect()->route('platform.product.list');
    }
}
