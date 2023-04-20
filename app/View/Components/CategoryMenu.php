<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryMenu extends Component
{
    public $parentCategories;
    public $subCategoryMenu;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->parentCategories = Category::ParentNull()->get();
        $this->subCategoryMenu = [];
        if(request()->has('category_id')){
            $this->subCategoryMenu = Category::ParentId(request()->get('category_id'))->get();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.category-menu');
    }
}
