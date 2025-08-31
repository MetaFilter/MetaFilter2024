@php
use App\Enums\ModerationTypeEnum;
@endphp

<article class="comment @if ($isRemoved) moderator-removed @endif"
    id="comment-{{ $commentId }}"
    data-comment-id="{{ $commentId }}"
    @if (!$isRemoved)
        data-member-id="{{ $comment->user->id }}"
    @endif
>
    @if ($isModerating)
        <livewire:comments.comment-content
            :comment-id="$commentId"
            :comment="$comment"
            :child-comments="$childComments"
            :$state
            @comment-form-state-changed="setState($event.detail.state)"
        />
    @elseif ($appearanceComment)
        @if ($moderationType === ModerationTypeEnum::Wrap)
            <livewire:comments.comment-wrapper
                wire:key="comment-wrapper-{{ $appearanceCommentId ?? $commentId }}"
                :comment-id="$commentId"
                :comment="$comment"
                :child-comments="$childComments"
                :$state
                @comment-form-state-changed="setState($event.detail.state)"
            />
        @elseif ($moderationType === ModerationTypeEnum::Remove)
            @moderator
                <livewire:comments.moderator-comment
                    wire:key="moderator-comment-{{ $appearanceComment->id }}"
                    :comment-id="$appearanceComment->id"
                    :comment="$appearanceComment"
                    :$state
                    show-moderator-toggle="true"
                    @comment-form-state-changed="setState($event.detail.state)"
                />
            @endmoderator
        @else
            <livewire:comments.moderator-comment
                wire:key="moderator-comment-{{ $appearanceComment->id }}"
                :comment-id="$appearanceComment->id"
                :comment="$appearanceComment"
                :$state
                show-moderator-toggle="true"
                @comment-form-state-changed="setState($event.detail.state)"
            />
        @endif
    @else
        @if ($isInitiallyBlurred)
            <livewire:comments.comment-blur
                wire:key="comment-blur-{{ $blurCommentId ?? $commentId }}"
                :comment-id="$commentId"
                :comment="$comment"
                :child-comments="$childComments"
                :$state
                @comment-form-state-changed="setState($event.detail.state)"
            />
        @else
            <livewire:comments.comment-content
                :comment-id="$commentId"
                :comment="$comment"
                :child-comments="$childComments"
                :$state
                @comment-form-state-changed="setState($event.detail.state)"
            />
        @endif
    @endif

    @if ($isEditing === true)
        <livewire:comments.comment-form-component
            wire:key="edit-comment-{{ $commentId }}"
            :comment="$comment"
            is-editing="true"
            @comment-updated="closeForm()"
            @comment-stored="closeForm()"
        />
    @endif

    @if ($isFlagging === true)
        <livewire:flags.flag-component
            wire:key="flagging-comment-{{ $commentId }}"
            :comment-id="$comment->id"
            :model="$comment"
            @comment-flagged="addUserFlag($event.detail.id)"
            @comment-flag-cancelled="closeForm()"
            @comment-flag-deleted="removeUserFlag($event.detail.id)"
        />
    @endif

    @if ($isReplying === true)
        <livewire:comments.comment-form-component
            wire:key="reply-to-comment-{{ $commentId }}"
            :post-id="$comment->post_id"
            :parent-id="$commentId"
            is-replying="true"
            @comment-updated="closeForm()"
            @comment-stored="closeForm()"
        />
    @endif

    @if ($isModerating === true)
        <livewire:comments.comment-form-component
            wire:key="moderate-comment-{{ $commentId }}"
            :comment="$comment"
            is-moderating="true"
            @comment-updated="closeForm()"
            @comment-stored="closeForm()"
        />
    @endif

    @if ($hasModeratorActions)
        <livewire:comments.moderator-comment-list-component
            :parent-id="$commentId"
            :child-comments="$childComments->reverse()"
            :$state
            @comment-form-state-changed="setState($event.detail.state)"
        />
    @endif
</article>
