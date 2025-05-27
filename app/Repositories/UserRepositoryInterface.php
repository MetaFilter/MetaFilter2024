<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dtos\UserDto;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;


interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function createUser(UserDto $dto);

    public function updateState(User $user, string $state);

    public function findStaleUsers(): Collection;
}
