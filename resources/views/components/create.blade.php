<?php /** @var \App\Utils\Slug $slug */ ?>
<?php /** @var string[] $foreigns */ ?>
<?php /** @var \App\Utils\ForeignHandler $foreignHandler */ ?>

<form action="{{ route("$slug->prefix.store", $slug->organization()) }}" method="POST">
    @csrf

    <button type="submit" class="btn btn-primary">{{ __('Mentés') }}</button>

    @php($fields = $slug->model()->getFillable())
    @foreach($fields as $field)
        @if(\Str::endsWith($field, '_id'))
            @php($foreigns[] = $field)
            <input type="hidden" name="{{ $field }}" data-field>
            @continue
        @endif

        <div class="form-group row">
            <label for="{{ $field }}" class="col-md-4 col-form-label text-md-right">
                {{ trans("headers.$slug.$field") }}
            </label>

            <div class="col-md-6">
                @php($type = field_type($field))
                @if($type === 'checkbox')
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" name="{{ $field }}" value="0" checked>
                            {{ __('Nem') }}
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="{{ $field }}" value="1">
                            {{ __('Igen') }}
                        </label>
                    </div>
                @else
                    <input id="{{ $field }}" type="{{ $type }}" value="{{ old($field) }}"
                           class="form-control @error($field) is-invalid @enderror"
                           name="{{ $field }}" autocomplete="{{ $field }}">
                @endif

                @error($field)
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    @endforeach

    @foreach($foreigns as $foreign)
        @component('components.table', [
            'items' => $foreignHandler->relation($foreign)->cursor(),
            'headers' => $foreignHandler->headers($foreign),
            'foreign' => $foreign,
        ])
        @endcomponent
    @endforeach

    <button type="submit" class="btn btn-primary">{{ __('Mentés') }}</button>
</form>
