<link rel="preconnect" href="https://fonts.bunny.net">
<link rel="stylesheet" href="https://fonts.bunny.net/css?family=merriweather:400,400i">
<link rel="stylesheet" href="https://fonts.bunny.net/css?family=montserrat:400,400i">
<link rel="stylesheet" href="https://fonts.bunny.net/css?family=source-sans-pro:200,200i,300,300i,400,400i,600,600i,700,700i">

@if (isset($useLivewire) && $useLivewire === true)
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @livewireStyles
@endif

@if (isset($useWysiwyg) && $useWysiwyg === true)
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
@endif

@vite('resources/sass/app.scss')
{{--
@if ($subsiteHasTheme && $subdomain !== 'www')
    @vite("resources/sass/themes/$subdomain.scss")
@else
    @vite('resources/sass/themes/metafilter.scss')
@endif
--}}
@stack('styles')
