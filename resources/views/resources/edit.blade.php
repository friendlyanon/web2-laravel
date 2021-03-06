@extends('layouts.app')

<?php /** @var \App\Utils\Slug $slug */ ?>
<?php /** @var \App\Organization $model */ ?>

@php($header = data_get($model, data_get($model, 'cardKey', 'name'), "$slug"))
@section('content')
    @component('components.card', compact('header'))
        @component('components.edit', compact('slug', 'model', 'foreignHandler'))
        @endcomponent
    @endcomponent
@endsection
