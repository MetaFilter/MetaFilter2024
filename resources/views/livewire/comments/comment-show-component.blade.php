<article class="comment">
    {{ $comment->body }}

    <footer class="comment-footer">
        <p>
            <x-icons.icon-component filename="card-text" />
            {{ $wordCount . ' ' .  trans('words') }}
        </p>

        <x-members.profile-link-component :user="$comment->user" />

        @include('comments.partials.comment-timestamp', [
            'comment' => $comment,
        ])

        @auth
            <button
                class="button footer-button"
                wire:click.prevent="toggleReplying()"
                aria-controls="comment-reply-form-{{ $comment->id }}"
                aria-expanded="{{ $this->isReplying ? 'true' : 'false' }}">
                <x-icons.icon-component filename="reply-fill" />
                {{ trans('Reply') }}
            </button>

            @if ($comment->user_id === $authorizedUserId)
            @endif
                <button
                    class="button footer-button"
                    wire:click.prevent="toggleEditing()"
                    aria-controls="edit-comment-form-{{ $comment->id }}"
                    aria-expanded="{{ $this->isEditing ? 'true' : 'false' }}">
                    <x-icons.icon-component filename="pencil-square" />
                    {{ trans('Edit') }}
                </button>

            <livewire:favorites.favorite-component :model="$comment" />

            @auth
                @if ($userFlagged === true)
                    <button
                        class="button footer-button"
                        title="{{ trans('Remove flag') }}">
                        <x-icons.icon-component filename="{{ $flagIconFilename  }}" />
                        {{ $flagCount }}
                    </button>
                @else
                    <button
                        class="button footer-button"
                        wire:click="toggleFlagging()"
                        aria-controls="flag-comment-form-{{ $comment->id }}"
                        aria-expanded="{{ $this->isFlagging ? 'true' : 'false' }}">
                        <x-icons.icon-component filename="{{ $flagIconFilename }}" />
                    </button>
                @endif
            @endauth
        @endauth

        @guest
            <button class="button footer-button" disabled>
                <x-icons.icon-component filename="flag" />
                {{ $flagCount }}
            </button>
        @endguest

        @if ($isEditing === true)
            <livewire:comments.comment-form-component
                wire:key="'edit-comment-' . $comment->id"
                :authorized-user-id="$authorizedUserId"
                :post-id="$comment->post_id"
                :comment="$comment"
                button-text="{{ trans('Update') }}"
                is-editing="true"
            />
        @endif

        @if ($isReplying === true)
            <livewire:comments.reply-to-comment-component
                wire:key="'reply-to-comment-' . $comment->id"
                :authorized-user-id="$authorizedUserId"
                :post-id="$comment->post_id"
                :parent-id="$comment->id"
                is-replying="true"
            />
        @endif

        @if ($isFlagging === true)
            <livewire:flags.flag-component
                wire:key="'flagging-comment-' . $comment->id"
                :comment-id="$comment->id"
                :model="$comment"
                is-flagging="true"
            />
    @endif
</article>
