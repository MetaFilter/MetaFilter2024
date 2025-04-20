<?php

declare(strict_types=1);

namespace App\Services\Imports;

use App\Jobs\Import\ImportUser;
use App\Traits\ImportTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use RuntimeException;

final class UserImportService
{
    use ImportTrait;

    private int $counter;

    public function __construct()
    {
        $this->counter = 0;
    }

    public function import(): void
    {
        $this->prepareDatabaseForImport();
            model: new User(),
            filePath: 'app/test,csv',
            columns: self::COLUMNS,
            columnLabel: 'date_of_birth',
            columnValue: "STR_TO_DATE(@date_of_birth, '%c/%d/%Y')",
        );

        DB::table('users')->truncate();

        LazyCollection::make(items: function () {
            $file = fopen(storage_path('app/imports/users_all.csv'), mode: 'r');

            if ($file === false) {
                throw new RuntimeException(message: 'Failed to open the file.');
            }

            while (($row = fgets($file)) !== false) {
                yield str_getcsv($row);
            }
        })
        ->each(function ($row) {
            $this->counter++;

            if ($this->counter === 2) {
                \Log::debug('UserImportService row' . print_r($row, true));
                ImportUser::dispatch($row);
                //                dispatch(new ImportUser($row));
            }
        });
    }
}
