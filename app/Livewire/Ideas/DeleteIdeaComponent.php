<?php

declare(strict_types=1);

namespace App\Livewire\Ideas;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class DeleteIdeaComponent extends Component
{
    public function render(): View
    {
        return view('livewire.ideas.delete-idea-component');
    }
}
