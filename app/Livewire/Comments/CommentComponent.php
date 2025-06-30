<?php

declare(strict_types=1);

namespace App\Livewire\Comments;

use App\Enums\LivewireEventEnum;
use App\Models\Comment;
use App\Models\Flag;
use App\Models\Post;
use App\Models\User;
use App\Traits\CommentComponentTrait;
use App\Traits\SessionTimezoneTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

final class CommentComponent extends Component
{
    use CommentComponentTrait;
    use SessionTimezoneTrait;

    // Data
    public ?int $authorizedUserId;
    public string $body = '';
    public ?int $parentId = null;
    public int $flagCount = 0;
    public string $flagIconFilename = 'flag';
    public string $flagButtonText = '';
    public bool $userFlagged = false;

    // State
    public bool $isEditing = false;
    public bool $isFlagging = false;
    public bool $isReplying = false;

    public Comment $comment;
    public CommentForm $commentForm;
    public Post $post;
    public ?User $user;

    public function mount(Comment $comment, Post $post): void
    {
        $this->authorizedUserId = auth()->id() ?? null;

        $this->comment = $comment;
        $this->commentForm->setComment($comment);

        $this->post = $post;

        $this->body = $comment->body;

        $this->user = auth()->user() ?? null;

        $this->updateFlagCount();
        $this->hasUserFlagged();

        $this->flagIconFilename = $this->getFlagIconFilename();
        $this->flagButtonText = $this->getFlagTitleText();
    }

    public function render(): View
    {
        return view('livewire.comments.comment-component');
    }

    private function getFlagIconFilename(): string
    {
        return $this->userFlagged ? 'flag-fill' : 'flag';
    }

    private function getFlagTitleText(): string
    {
        return $this->userFlagged ? trans('Remove flag') : trans('Flag this comment');
    }

    private function hasUserFlagged(): void
    {
        $userFlagCount = DB::table(table: 'markable_flags')
            ->where(column: 'user_id', operator: '=', value: auth()->id())
            ->where(column: 'markable_id', operator: '=', value: $this->comment->id)
            ->where(column: 'markable_type', operator: 'LIKE', value: '%Comment%')
            ->count();

        $this->userFlagged = $userFlagCount > 0;
    }

    #[On([
        LivewireEventEnum::CommentStored->value,
        LivewireEventEnum::CommentDeleted->value,
        LivewireEventEnum::CommentFlagged->value,
        LivewireEventEnum::CommentUpdated->value,
        LivewireEventEnum::EscapeKeyClicked->value,
    ])]
    public function closeForm(): void
    {
        $this->reset([
            'body',
        ]);

        $this->stopEditing();
        $this->stopFlagging();
        $this->stopReplying();
    }

    private function updateFlagCount(): void
    {
        $this->flagCount = Flag::count($this->comment);
    }

    #[On('comment-flagged.{comment.id}')]
    public function addUserFlag(): void
    {
        \Log::debug('CommentComponent::addUserFlag');
        $this->userFlagged = true;
        $this->flagCount++;
    }

    #[On('comment-flag-deleted.{comment.id}')]
    public function removeUserFlag(): void
    {
        $this->userFlagged = false;
        $this->flagCount--;
    }
}
