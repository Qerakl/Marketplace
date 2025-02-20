<?php

namespace App\Orchid\Screens\Category;

use App\Models\ProductCategory;
use App\Orchid\Layouts\Category\CategoryCreateLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class CategoryCreateScreen extends Screen
{
    public $category;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(ProductCategory $category): iterable
    {
        return [
            'category' => $category,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Создание категории';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать категорию')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->category->exists),

            Button::make('Обновить категорию')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->category->exists),

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
            CategoryCreateLayout::class,
        ];
    }

    public function createOrUpdate(Request $request)
    {
        $data = $request->get('category');
        $this->category->fill($data)->save();
        Alert::info('Успешно добавлена категория');
        return redirect()->route('platform.category.list');
    }
}
