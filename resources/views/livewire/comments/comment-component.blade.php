<article class="comment">
    {{ $comment->body }}

    <footer class="comment-footer">
        <p>
            <x-icons.icon-component filename="card-text"/>
            {{ $wordCount . ' ' .  trans('words') }}
        </p>

        <x-members.profile-link-component :user="$comment->user"/>

        @include('comments.partials.comment-timestamp', [
            'comment' => $comment,
        ])

        @auth
            <livewire:bookmarks.bookmark-component :model="$comment"/>
        @endauth

        <livewire:favorites.favorite-component :model="$comment"/>

        @auth
            @if ($comment->user_id === auth()->id())
                @include('livewire.comments.partials.toggle-editing-button')
            @endif
            @include('livewire.comments.partials.toggle-replying-button')
        @endauth

        @include('livewire.comments.partials.toggle-flagging-button')
    </footer>
    {{--
        @include('comments.partials.comment-admin-footer')
    --}}
    @if ($isEditing === true)
        <livewire:comments.comment-form-component
            wire:key="'edit-comment-' . $comment->id"
            :post-id="$comment->post_id"
            :comment="$comment"
            :is-editing="$isEditing"
            button-text="{{ trans('Update') }}"
        />
    @endif

    @if ($isFlagging === true)
        <livewire:flags.flag-component
            wire:key="'flagging-comment-' . $comment->id"
            :comment-id="$comment->id"
            :model="$comment"
        />
    @endif

    @if ($isReplying === true)
        <livewire:comments.comment-form-component
            wire:key="'reply-to-comment-' . $comment->id"
            :post-id="$comment->post_id"
            :parent-id="$comment->id"
            :is-replying="$isReplying"
            button-text="{{ trans('Reply') }}"
        />
    @endif
</article>
