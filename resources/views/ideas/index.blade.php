@extends('layouts.app')

@section('title', $title ?? 'Untitled')

@section('contents')
    <livewire:ideas.ideas-index-component />
@endsection
