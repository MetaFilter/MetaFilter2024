<?php

declare(strict_types=1);

namespace App\Livewire\Comments;

use App\Enums\LivewireEventEnum;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\CommentRepositoryInterface;
use App\Traits\AuthStatusTrait;
use App\Traits\SubsiteTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

final class CommentIndexComponent extends Component
{
    use AuthStatusTrait;
    use SubsiteTrait;

    public ?int $authorizedUserId;
    public bool $hasMoreComments = false;
    public Comment $comment;
    public Post $post;
    public Collection $comments;
    public string $recordsText = 'comments';

    protected CommentRepositoryInterface $commentRepository;
    public function boot(CommentRepositoryInterface $commentRepository): void
    {
        $this->commentRepository = $commentRepository;
    }

    public function mount(Post $post): void
    {
        $this->authorizedUserId = $this->getAuthorizedUserId();

        $this->post = $post;
        $this->getComments();
        $this->setRecordsText();
    }

    public function render(): View
    {
        $comments = $this->comments;

        return view('livewire.comments.comment-index-component', [
            'comments' => compact('comments'),
        ]);
    }

    #[On(LivewireEventEnum::CommentStored->value)]
    public function getComments(): void
    {
        $this->comments = $this->commentRepository->getCommentsByPostId($this->post->id);
    }

    //    #[On('comment-deleted.{comment.id}')]
    public function deleteComment(int $commentId): void
    {
        $this->comments = $this->comments->reject(function ($comment) use ($commentId) {
            return $comment['id'] === $commentId;
        });

        $this->commentRepository->delete($commentId);
    }

    //    #[On('comment-updated.{data}')]
    public function updateComment(array $data): void
    {
        $this->comments = array_map(function ($comment) use ($data) {

            if ($comment['id'] == $data['id']) {
                $comment['text'] = $data['text'];
            }

            return $comment;

        }, $this->comments);
    }

    private function setRecordsText(): void
    {
        $subdomain = $this->getSubdomain();

        $this->recordsText = match ($subdomain) {
            'ask' => trans('answers'),
            default => trans('comments'),
        };
    }
}
