<?php

declare(strict_types=1);

namespace App\Livewire\Localization;

use App\Traits\SessionTimezoneTrait;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SwitchTimezoneComponent extends Component
{
    use SessionTimezoneTrait;

    public function render(): View
    {
        return view('livewire.localization.switch-timezone-component');
    }
}
