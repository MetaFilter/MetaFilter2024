<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\RoleNameEnum;
use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

final class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return true;
    }

    public function view(User $user, Post $post): bool
    {
        if ($user->hasRole([RoleNameEnum::MODERATOR->value]) || $post->user_id === $user->id) {
            return true;
        }

        return $post->published_at !== null;
    }

    public function create(User $user): bool
    {
        //        return $user->can('create_post');
        return true;
    }

    public function update(User $user, Post $post): bool
    {
        if ($user->hasRole([RoleNameEnum::MODERATOR->value]) || $post->user_id === $user->id) {
            return true;
        }

        return $post->published_at !== null;
    }

    public function delete(User $user, Post $post): bool
    {
        //        return $user->can('delete_post');
        return true;
    }

    public function deleteAny(User $user): bool
    {
        //        return $user->can('delete_any_post');
        return true;
    }

    public function forceDelete(User $user, Post $post): bool
    {
        //        return $user->can('force_delete_post');
        return true;
    }

    public function forceDeleteAny(User $user): bool
    {
        //        return $user->can('force_delete_any_post');
        return true;
    }

    public function restore(User $user, Post $post): bool
    {
        //        return $user->can('restore_post');
        return true;
    }

    public function restoreAny(User $user): bool
    {
        //        return $user->can('restore_any_post');
        return true;
    }

    public function replicate(User $user, Post $post): bool
    {
        //        return $user->can('replicate_post');
        return true;
    }

    public function reorder(User $user): bool
    {
        //        return $user->can('reorder_post');
        return true;
    }
}
