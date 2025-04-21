<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme-preference="light">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@include('layouts.partials.window-title') - {{ $subsiteName }}</title>

@include('layouts.partials.styles')
@include('layouts.partials.social-media-meta-tags')
@include('layouts.partials.previous-next-meta')
@include('layouts.partials.favicons')

@if (isset($canonicalUrl))
    <link rel="canonical" href="{{ $canonicalUrl }}">
@endif

@if (isset($useWysiwyg) && $useWysiwyg === true)
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
    <meta name="ckeditor-config" content='@json(config("ckeditor"))'>
@endif

</head>
<body>

@include('layouts.partials.skip-navigation')

<header class="site-header" id="site-header">
    @include('layouts.partials.global-header')
    <livewire:site-banner.site-banner-component />
    @include('layouts.navigation.global-navigation')
</header>

<header class="subsite-header">
    @include('layouts.navigation.primary-navigation')
    @if (isset($showSecondaryNavigation) && $showSecondaryNavigation === true)
        @include('layouts.navigation.secondary-navigation')
    @endif
</header>

<section class="container">
    <!-- He's the DJ; I'm the wrapper -->
    <div class="columns">
        <main class="column is-two-thirds" id="main-contents">
            <x-buttons.top-bottom-button-component location="top" />

            @if (isset($showTitle) && $showTitle === true)
                <h1>{{ $title }}</h1>
            @endif

            @include('layouts.partials.flash-messages')

            @yield('contents')
        </main>

        <aside class="column main-sidebar">
            @include('layouts.partials.main-sidebar')
        </aside>

        <x-buttons.top-bottom-button-component location="bottom" />
    </div>
</section>

<footer class="footer site-footer" id="site-footer">
    @include('layouts.partials.global-footer')
    @include('layouts.partials.fine-print')
</footer>

@include('layouts.partials.scripts')
{{--
<script>
    document.addEventListener('comment-flagged', event => {
        alert(`Comment was flagged: ${event.detail.message}`);
    });
</script>
--}}
</body>
</html>
