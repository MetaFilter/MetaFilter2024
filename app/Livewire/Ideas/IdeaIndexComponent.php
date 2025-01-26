<?php

declare(strict_types=1);

namespace App\Livewire\Ideas;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class IdeaIndexComponent extends Component
{
    public function render(): View
    {
        return view('livewire.ideas.idea-index-component');
    }
}
