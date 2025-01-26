@extends('layouts.app')

@section('title', $title ?? 'Untitled')

@section('contents')
    <livewire:ideas.idea-show-component
        :idea="$idea"
        :votesCount="$votesCount"
    />

    <livewire:ideas.idea-comments-component :idea="$idea" />
@endsection
