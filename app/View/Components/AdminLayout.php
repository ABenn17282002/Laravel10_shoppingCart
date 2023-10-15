<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminLayout extends Component
{

    /**
     * Get the view / contents that represents the component.
     * Admin用component_レンダー
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('layouts.admin');
    }
}
