<?php

declare(strict_types=1);

namespace App\Pipes;

use Closure;

abstract class BasePipe
{
    abstract protected function handle(array $data, Closure $next);
}
