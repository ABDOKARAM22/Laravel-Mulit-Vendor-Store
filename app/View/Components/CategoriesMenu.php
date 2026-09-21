<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Category;

class CategoriesMenu extends Component
{
    public $categories;
    
    public function __construct()
    {
        $this->categories = Category::where('status', 'Active')->orderBy('name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.categories-menu');
    }
}
