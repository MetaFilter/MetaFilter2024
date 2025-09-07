<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dtos\UserDto;
use App\Models\User;
use App\Enums\UserStateEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;


final class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function createUser(UserDto $dto): User
    {
        return User::create([
            'username' => $dto->username,
            'name' => $dto->name ?? null,
            'email' => $dto->email,
            'password' => $dto->password,
            'state' => $dto->state,
        ]);
    }

    public function updateState(User $user, string $state): void
    {
        $user->state = $state;

        $user->save();
    }

    public function findStaleUsers(): Collection
    {
        return User::query()
            ->where('state', UserStateEnum::Pending->value)
            ->whereNull('email_verified_at')
            ->whereNull('pm_type')
            ->where('updated_at', '<', Carbon::now()->subHours(24))
            ->get();
    }
}
