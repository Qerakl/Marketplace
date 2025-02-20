<?php

namespace App\Orchid\Screens\Product;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Orchid\Layouts\Product\ProductCreateLayout;
use Illuminate\Http\Request;
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

    public function createOrUpdate(Request $request)
    {
        $data = $request->get('product');
        $data['category_id'] = $data['category'];
        unset($data['category']);
        if (!empty($data['image'])) {
            // Путь к файлу, загруженному Cropper (например, storage/app/public/2025/02/20/xxx.jpg)
            $originalPath = storage_path('app/public/' . $data['image']);

            if (file_exists($originalPath)) {
                // Генерируем новое имя файла
                $fileName = basename($originalPath);
                $newPath = 'products/' . $fileName;

                // Перемещаем файл в нужную директорию
                Storage::disk('public')->move($data['image'], $newPath);

                // Обновляем путь в данных
                $data['image'] = $newPath;
            }
        } else {
            // Если файл не загружен, сбрасываем поле
            $data['image'] = null;
        }
        // Заполняем модель данными
        $this->product->fill($data);
        // Сохраняем модель
        $saved = $this->product->save();
        // Уведомление в зависимости от контекста
        $message = $this->product->wasRecentlyCreated
            ? 'Вы успешно создали товар ' . $this->product->name
            : 'Вы успешно обновили товар ' . $this->product->name;

        Alert::success($message);
        return redirect()->route('platform.product.list');
    }


}
