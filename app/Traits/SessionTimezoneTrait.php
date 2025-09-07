<?php

declare(strict_types=1);

namespace App\Traits;

use Carbon\CarbonTimezone;
use Carbon\Exceptions\InvalidTimeZoneException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Session;

trait SessionTimezoneTrait
{
    use LoggingTrait;

    #[Session(key: 'displayTimezone')]
    #[Locked]
    public ?string $displayTimezone = null;

    public function getDisplayTimezone(): string
    {
        // For some reason, calling session('displayTimezone') will sometimes return a value
        // when $this->displayTimezone is null.
        return $this->displayTimezone ?? session('displayTimezone') ?? config('app.timezone');
    }

    public function setDisplayTimezone(string $timezone): void
    {
        try {
            // Try to create a CarbonTimezone object to validate the timezone string.
            CarbonTimezone::create($timezone);

            // If we get here, the timezone is valid, so we can set it.
            $this->displayTimezone = $timezone;
        } catch (InvalidTimeZoneException $e) {
            $this->logError('Invalid timezone: ' . $timezone);
        }
    }
}
