<?php

declare(strict_types=1);

namespace App\Jobs\Import;

use App\Pipes\CreateUser;
use App\Pipes\CreateUserDto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class ImportUser implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public array $row = [];

    public function __construct(array $row)
    {
        $this->row = $row;
    }

    public function handle(): void
    {
        $data = [];

        $data['row'] = $this->row;

        app(abstract: Pipeline::class)
            ->send($data)
            ->through([
                CreateUserDto::class,
                CreateUser::class,
            ])->thenReturn();
    }
}
