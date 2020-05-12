<?php /** @var \App\Utils\Slug|null $slug */ ?>
<?php /** @var \App\Model[] $items */ ?>
<?php /** @var string[] $headers */ ?>
<?php /** @var boolean $canModify */ ?>

@php($slug ??= null)

<table class="table">
    <thead class="thead-light">
    <th scope="col"><input type="checkbox"></th>
    @foreach($headers as $name => $path)
        <th scope="col" data-sort>{{ trans($name) }}</th>
    @endforeach
    @if($slug !== null)
        <th scope="col">{{ __('Műveletek') }}</th>
    @endif
    </thead>

    <tbody>
    @forelse($items as $item)
        <tr data-id="{{ $item->id }}">
            <td><input type="checkbox"></td>

            @foreach($headers as $path)
                <td>{{ table_value($item, $path) }}</td>
            @endforeach

            @if($slug !== null)
                @component('components.actions', compact('item', 'canModify', 'slug'))
                @endcomponent
            @endif
        </tr>
    @empty
        <tr><td data-colspan>{{ __('(üres)') }}</td></tr>
    @endforelse
    </tbody>
</table>
