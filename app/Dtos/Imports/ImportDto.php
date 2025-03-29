<?php

declare(strict_types=1);

namespace App\Dtos\Imports;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

readonly class ImportDto
{
    public function __construct(
        public Model|User $model,
        public string $filePath,
        public array $columns,
        public string $columnLabel,
        public string $columnValue,
    ) {}
}
