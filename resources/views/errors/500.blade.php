@extends('layouts.errors')

@section('title', trans('Server Error'))
@section('code', '500')
@section('message', trans('Server Error'))

@push('styles')
    <style>
        body {
            background-color: transparent;
        }

        html {
            background-attachment: fixed;
            background-image: url('/images/backgrounds/matrix-code.jpg');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
@endpush
