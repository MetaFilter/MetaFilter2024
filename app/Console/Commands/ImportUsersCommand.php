<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Imports\UserImportService;
use Illuminate\Console\Command;

final class ImportUsersCommand extends Command
{
    protected $signature = 'mefi:import-users';
    protected $description = 'Import users from a file';

    public function handle(UserImportService $userImportService): void
    {
        $userImportService->import();
    }
}
