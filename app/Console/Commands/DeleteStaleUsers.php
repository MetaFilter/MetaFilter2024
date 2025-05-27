<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UserService;
use App\Enums\UserStateEnum;

final class DeleteStaleUsers extends Command
{
    protected $signature = 'users:delete-stale {--force : Skip deletion confirmation}';
    protected $description = 'Delete stale users from database';
    protected UserService $userService;


    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    public function handle(): int
    {
        $this->info('Finding stale users...');

        $staleUsers = $this->userService->getStaleUsers();

        if ($staleUsers->isEmpty()) {
            $this->info('No stale users found.');
            return Command::SUCCESS;
        }
        $count = $staleUsers->count();
        $this->warn("Found {$count} stale user(s).");

        $this->table(
            ['ID', 'Username', 'Email', 'Last Updated'],
            $staleUsers->map(function ($user) {
                return [
                    $user->id,
                    $user->username,
                    $user->email,
                    $user->updated_at->format('Y-m-d H:i:s'),
                ];
            })->all()
        );

        if (!$this->option('force')) {
            if (!$this->confirm("Are you sure you want to delete these {$count} user(s)? This action cannot be undone.")) {
                $this->info('Operation cancelled by user.');
                return Command::SUCCESS;
            }
        }

        $this->info('Proceeding with deletion...');

        $deletedCount = 0;
        $errorCount = 0;

        foreach ($staleUsers as $user) {
            try {
                if ($user->forceDelete()) {
                    $this->info("User ID: {$user->id} ({$user->username}) deleted successfully.");
                    $deletedCount++;
                } else {
                    $this->error("Failed to delete User ID: {$user->id} ({$user->username}).");
                    $errorCount++;
                }
            } catch (Throwable $e) {
                $this->error("Error deleting User ID: {$user->id} ({$user->username}): " . $e->getMessage());
                $errorCount++;
            }

        }

        $this->info("Deletion process completed. {$deletedCount} user(s) deleted.");
        if ($errorCount > 0) {
            $this->error("{$errorCount} user(s) could not be deleted. Check logs for details.");
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
