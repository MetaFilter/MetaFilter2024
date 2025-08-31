<div class="moderator-message moderation-action {{ $moderationClass }}" id="comment-{{ $comment->id }}">
    <aside class="moderation-action">
        {{ trans($moderationAction) }}
    </aside>

    <div class="comment-container">
        <section class="moderator-content">
            {!! $comment->body !!}
        </section>

        <footer class="comment-footer">
            <div class="comment-metadata">
                <x-members.profile-link-component :user="$comment->user"/>

                @include('comments.partials.comment-timestamp')
            </div>

            @moderator
                @if ($showModeratorToggle)
                    <div class="button-group">
                        @include('livewire.comments.partials.toggle-moderating-button', [
                            'commentId' => $comment->id,
                        ])
                    </div>
                @endif
            @endmoderator
        </footer>
    </div>
</div>