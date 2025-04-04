<?php

declare(strict_types=1);

namespace App\Imports;

use App\Jobs\Import\ImportUserRecords;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

final class UsersImport implements ToCollection, WithHeadingRow
{
    use Importable;

    private const int BATCH_SIZE = 1000;
    private array $users;

    public function __construct()
    {
        $this->resetUsers();
    }

    public function collection(Collection $collection): void
    {
        $counter = 0;

        foreach ($collection as $row) {
            $counter++;

            $this->users[] = [
                'id' => $row['user_ID'],
                'username' => $row['user_name'],
                'hashed_password' => $row['user_passhash'],
                'salt' => $row['user_salt'],
                'email' => $row['user_email'],
                'paypal_email' => $row['paypal_email'],
                'show_email' => $row['user_email_pref'],
                'homepage_url' => $row['user_web'],
            ];

            if ($counter % self::BATCH_SIZE === 0) {
                $this->dispatchJob();

                $this->resetUsers();
            }
        }
    }

    private function resetUsers(): void
    {
        $this->users = [];
    }

    private function dispatchJob(): void
    {
        dispatch(new ImportUserRecords($this->users));
    }
}
