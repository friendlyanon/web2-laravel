@extends('layouts.app')

<?php /** @var \App\Utils\Slug $slug */ ?>
<?php /** @var array $table */ ?>

@section('content')
    @component('components.card', ['header' => trans("headers.card.$slug")])
        <div class="mb-2 d-flex table-bar" style="justify-content: flex-end">
            @if($table['canModify'])
                <a href="{{ route("$slug->prefix.create", $slug->organization()) }}"
                   class="btn btn-primary">
                    {{ __('Létrehozás') }}
                </a>

                <div class="flex-grow-1"></div>
            @endif

            <div class="d-inline-block">
                <input type="text" class="form-control search-box"
                       placeholder="{{ __('Keresés') }}">
            </div>
        </div>

        @component('components.table', $table)
        @endcomponent
    @endcomponent
@endsection
