@extends('layouts.app')

@section('content')
    @component('components.card', ['header' => 'Dashboard'])
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <ul class="list-group">
            @can('access_users')
                <li class="list-group-item">
                    <a href="{{ route('users.index') }}">
                        Manage users
                    </a>
                </li>
            @endcan
            <li class="list-group-item">
                <a href="{{ route('organizations.index') }}">
                    View organizations
                </a>
            </li>
        </ul>
    @endcomponent
@endsection
