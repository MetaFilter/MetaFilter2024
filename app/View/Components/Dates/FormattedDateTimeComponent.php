<?php

declare(strict_types=1);

namespace App\View\Components\Dates;

use App\Traits\SessionTimezoneTrait;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class FormattedDateTimeComponent extends Component
{
    use SessionTimezoneTrait;

    public Carbon $date;
    public string $format = 'Y-m-d H:i:s';

    public function __construct(Carbon $date, $format = null)
    {
        $this->date = $date;
        $this->format = $format;
    }

    private function format()
    {
        return $this->format ?? 'Y-m-d H:i:s';
    }

    public function render(): View
    {
        $formattedDate = $this->getFormattedDate();

        return view('components.dates.formatted-date-time-component', [
            'date' => $this->date,
            'formattedDate' => $formattedDate,
        ]);
    }

    private function getFormattedDate(): string
    {
        $date = $this->date->tz($this->getDisplayTimezone());
        $formattedDate = $date->format($this->format());

        return $this->addPeriods($formattedDate);
    }

    private function addPeriods(string $date): string
    {
        $date = mb_ereg_replace(pattern: 'am', replacement: 'a.m.', string: $date);

        return mb_ereg_replace(pattern: 'pm', replacement: 'p.m.', string: $date);
    }
}
