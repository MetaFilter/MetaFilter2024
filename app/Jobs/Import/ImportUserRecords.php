<?php

declare(strict_types=1);

namespace App\Jobs\Import;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class ImportUserRecords implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public array $users = [];

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function handle(): void
    {
        User::insert($this->users);
    }
}
