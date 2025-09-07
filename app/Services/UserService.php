<?php

declare(strict_types=1);

namespace App\Services;

use App\Dtos\UserDto;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Traits\LoggingTrait;
use Exception;
use Illuminate\Database\Eloquent\Collection;


final class UserService
{
    use LoggingTrait;

    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function store(UserDto $dto): ?User
    {
        try {
            $data = [
                'username' => $dto->username,
                'password' => bcrypt($dto->password),
                'email' => $dto->email,
                'name' => $dto->name,
                'state' => $dto->state,
            ];

            return $this->userRepository->create($data);
        } catch (Exception $exception) {
            $this->logError($exception);

            return null;
        }
    }

    public function update(int $userId, array $data): ?User
    {
        return $this->userRepository->update($userId, $data);
    }

    public function getStaleUsers(): Collection
    {
        try {
            return $this->userRepository->findStaleUsers();
        } catch (Exception $exception) {
            $this->logError($exception);

            return collect();
        }
    }
}
