<time datetime="{{ $comment->created_at->format('Y-m-d H:i:d') }}">
    <a href="#comment-{{ $comment->id }}" class="footer-info" title="{{ trans('Permanent link to this comment') }}">
        <x-icons.icon-component filename="clock" class="icon-small" />
        {{ $comment->created_at->format('g:i a') }}
    </a>

    <span class="footer-info">
        <x-icons.icon-component filename="calendar3" class="icon-small" />
        {{ $comment->created_at->format('F j') }}
    </span>
</time>
