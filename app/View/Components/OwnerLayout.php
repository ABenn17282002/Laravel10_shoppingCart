<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OwnerLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represents the component.
     * owner用component_レンダー
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('layouts.owner');
    }
}
