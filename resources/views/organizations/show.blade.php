@extends('layouts.app')

<?php /** @var \App\Utils\Slug $slug */ ?>
<?php /** @var \App\Organization $model */ ?>

@section('content')
    @component('components.card', ['header' => $model->name])
        <ul class="list-group mb-4">
            @foreach([
                'discounts',
                'invoices',
                'partners',
                'partner_groups',
                'products',
                'taxes',
            ] as $res)
                <li class="list-group-item">
                    <a href="{{ route("organizations.$res.index", ['organization' => $model]) }}">
                        {{ trans("headers.card.$res") }}
                    </a>
                </li>
            @endforeach
        </ul>

        @component('components.show', compact('slug', 'model'))
        @endcomponent
    @endcomponent
@endsection
