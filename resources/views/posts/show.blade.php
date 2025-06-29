@extends('layouts.app')

@section('title', $title ?? 'Untitled')

@section('contents')
    @guest
        @include('posts.partials.show-not-logged-in', [
            'context' => 'comment'
        ])
    @endguest

    <article class="post post-show">
        <header>
            <h1>
                {!! $post->title !!}
            </h1>

            <p class="dateline">
                <time datetime="{{ $post->created_at->format('Y-m-d H:i:d') }}">
                    <x-icons.icon-component filename="calendar3" class="icon-small" />
                    {{ $post->created_at->format('F j, Y') }}

                    <x-icons.icon-component filename="clock" class="icon-small" />
                    {{ $post->created_at->format('g:i a') }}
                </time>

                <x-posts.post-rss-button :post="$post" />
            </p>
        </header>

        @if ($post->is_archived)
            <x-notifications.notification-component iconFilename="archive">
                {{ trans('This post has been archived and is closed to new comments.') }}
            </x-notifications.notification-component>
        @endif

        {!! $post->body !!}

        @if ($post->more_inside)
            {!! $post->more_inside !!}
        @endif

        @include('posts.partials.post-show-footer', [
            'post' => $post,
            'commentsCount' => $post->comments()->count(),
            'favoritesCount' => $post->favoriteCount(),
        ])
    </article>

    <section class="comments" id="comments">
        <livewire:comments.comment-list-component :post="$post" />
    </section>

    @if ($post->is_archived === false)
        @auth
            <h2>
                {{ trans('Add a comment') }}
            </h2>

            <livewire:comments.comment-form-component
                :post-id="$post->id"
            />
        @endauth
    @endif

    @if (isset($relatedPosts))
        @include('posts.partials.related-posts')
    @endif

    @include('posts.partials.previous-next')
@endsection
