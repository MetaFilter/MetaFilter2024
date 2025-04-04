<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use RuntimeException;

trait ImportTrait
{
    public function prepareDatabaseForImport(): void
    {
        DB::statement('SET @@session.unique_checks = 0');
        DB::statement('SET @@session.foreign_key_checks = 0');
    }

    public function openFileFromStorage(string $filePath)
    {
        if (!file_exists(storage_path($filePath))) {
            throw new RuntimeException("File not found: $filePath");
        }

        if (!is_readable(storage_path($filePath))) {
            throw new RuntimeException("File is not readable: $filePath");
        }

        return fopen(storage_path($filePath), 'r');
    }
}
