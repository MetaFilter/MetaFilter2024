<?php

declare(strict_types=1);

namespace App\Livewire\Comments;

use App\Enums\LivewireEventEnum;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class CommentShowComponent extends Component
{
    public Comment $comment;
    public ?int $authorizedUserId;
    public int $favoriteCount = 0;
    public string $favoriteIconFilename = 'heart';
    public int $flagCount = 0;
    public string $favoriteTitleText = 'Favorite';
    public string $flagIconFilename = 'flag';
    public string $flagTitleText = 'Flag';
    public bool $isEditing = false;
    public bool $isFlagging = false;
    public bool $isReplying = false;
    public bool $userFavorited = false;
    public bool $userFlagged = false;

    public function mount(Comment $comment, ?int $authorizedUserId): void
    {
        $this->authorizedUserId = $authorizedUserId;
        $this->comment = $comment;
    }

    public function render(): View
    {
        return view('livewire.comments.comment-show-component', [
            'authorizedUserId' => $this->authorizedUserId,
        ]);
    }

    public function toggleEditing(): void
    {
        if ($this->isEditing === true) {
            $this->stopEditing();
        } else {
            $this->startEditing();
        }
    }

    public function toggleFlagging(): void
    {
        if ($this->isFlagging === true) {
            $this->stopFlagging();
        } else {
            $this->startFlagging();
        }
    }

    public function toggleReplying(): void
    {
        if ($this->isReplying === true) {
            $this->stopReplying();
        } else {
            $this->startReplying();
        }
    }

    public function startEditing(): void
    {
        $this->isEditing = true;
        $this->stopFlagging();
        $this->stopReplying();
    }

    public function stopEditing(): void
    {
        $this->isEditing = false;
    }

    public function startFlagging(): void
    {
        $this->isFlagging = true;
        $this->stopEditing();
        $this->stopReplying();
    }

    public function stopFlagging(): void
    {
        $this->isFlagging = false;
    }

    public function startReplying(): void
    {
        $this->isReplying = true;
        $this->stopEditing();
        $this->stopFlagging();
    }

    public function stopReplying(): void
    {
        $this->isReplying = false;
    }

    #[On([
        LivewireEventEnum::CommentStored->value,
        LivewireEventEnum::CommentDeleted->value,
        LivewireEventEnum::CommentUpdated->value,
        LivewireEventEnum::EscapeKeyClicked->value,
    ])]
    public function closeForm(): void
    {
        $this->stopEditing();
        $this->stopFlagging();
        $this->stopReplying();
    }
}
