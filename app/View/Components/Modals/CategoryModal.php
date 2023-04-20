<?php

namespace App\View\Components\Modals;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryModal extends Component
{
    public $parentCategories;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->parentCategories = Category::ParentNull()->get()->pluck('name','id')->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.category-modal');
    }
}
