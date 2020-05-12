@extends('layouts.app')

<?php /** @var string[] $foreigns */ ?>
<?php /** @var \App\Utils\ForeignHandler $foreignHandler */ ?>
<?php /** @var \App\Utils\Slug $slug */ ?>
<?php /** @var string $message */ ?>

@php($foreigns ??= [])

@section('content')
    @component('components.card', ['header' => trans("headers.card.$slug")])
        @error('error')
        <div class="alert alert-danger mb-3" role="alert">
            {{ $message }}
        </div>
        @enderror

        @component('components.create', compact('slug', 'foreigns', 'foreignHandler'))
        @endcomponent
    @endcomponent
@endsection
