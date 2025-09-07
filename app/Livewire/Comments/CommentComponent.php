<?php

declare(strict_types=1);

namespace App\Livewire\Comments;

use App\Enums\CommentStateEnum;
use App\Enums\LivewireEventEnum;
use App\Enums\ModerationTypeEnum;
use App\Models\Comment;
use App\Traits\AuthStatusTrait;
use App\Traits\CommentComponentTrait;
use App\Traits\SessionTimezoneTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

final class CommentComponent extends Component
{
    use AuthStatusTrait;
    use CommentComponentTrait;
    use SessionTimezoneTrait;

    // State
    public CommentStateEnum $state = CommentStateEnum::Viewing;

    public function mount(int $commentId, ?Comment $comment, ?Collection $childComments): void
    {
        // On mount we expect the comment list to provide the comment model
        // and the moderator comments collection.
        $this->commentId = $commentId;
        $this->comment = $comment ?? Comment::find($commentId);
        if ($childComments) {
            $this->childComments = $childComments;
        }

        // Decide whether to blur the component initially.
        $this->isBlurred = $this->isInitiallyBlurred;
    }

    public function render(): View
    {
        $moderationType = $this->appearanceComment?->moderation_type ?? null;

        $hasModeratorActions = !empty($this->childComments) && $this->filterModeratorActions($this->childComments, $this->state === CommentStateEnum::Moderating)->isNotEmpty();

        // If there are no decorations to apply, just render the basic comment component.
        return view('livewire.comments.comment-component', [
            'comment' => $this->comment,
            'childComments' => $this->childComments,
            'moderationType' => $moderationType,
            'isInitiallyBlurred' => $this->isInitiallyBlurred,
            'isRemoved' => $moderationType === ModerationTypeEnum::Remove && !$this->isModerator(),
            'appearanceComment' => $this->appearanceComment,
            'appearanceCommentId' => $this->appearanceComment?->id,
            'blurCommentId' => $this->blurComment?->id,
            'isEditing' => $this->state === CommentStateEnum::Editing,
            'isFlagging' => $this->state === CommentStateEnum::Flagging,
            'isReplying' => $this->state === CommentStateEnum::Replying,
            'isModerating' => $this->state === CommentStateEnum::Moderating,
            'hasModeratorActions' => $hasModeratorActions,
        ]);
    }

    #[On([
        LivewireEventEnum::EscapeKeyClicked->value,
    ])]
    public function closeForm(): void
    {
        $this->state = CommentStateEnum::Viewing;
    }

    #[On([
        LivewireEventEnum::CommentStored->value,
        LivewireEventEnum::CommentUpdated->value,
    ])]
    public function reloadChildComments(int $id, ?int $parentId): void
    {
        if ($parentId === $this->commentId) {
            $this->childComments = $this->commentRepository->getCommentsByParentId($parentId);
            unset($this->appearanceComment, $this->blurComment, $this->isInitiallyBlurred);

            // Re-evaluate whether the comment should be blurred.
            $this->isBlurred = $this->isInitiallyBlurred;
        }
    }

    public function setState(CommentStateEnum $state): void
    {
        $this->state = $state;
    }

    public function addUserFlag(int $id): void
    {
        if ($id !== $this->comment->id) {
            return;
        }

        unset($this->userFlagged, $this->flagCount);

        $this->state = CommentStateEnum::Viewing;
    }

    public function removeUserFlag(int $id): void
    {
        if ($id !== $this->comment->id) {
            return;
        }

        unset($this->userFlagged, $this->flagCount);

        $this->state = CommentStateEnum::Viewing;
    }
}
