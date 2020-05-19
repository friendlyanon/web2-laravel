<?php /** @var \App\Model $model */ ?>
<?php /** @var \App\Utils\Slug $slug */ ?>
<?php /** @var string[] $foreigns */ ?>
<?php /** @var \App\Utils\ForeignHandler $foreignHandler */ ?>

<form action="{{ route("$slug->prefix.update", $slug($model)) }}" method="POST">
    @csrf
    @method('PATCH')

    <button type="submit" class="btn btn-primary">{{ __('Mentés') }}</button>

    @php($fields = $slug->model()->getFillable())
    @foreach($fields as $field)
        @if(\Str::endsWith($field, '_id'))
            @php($foreigns[] = $field)
            <input type="hidden" name="{{ $field }}" data-field
                   value="{{ old($field) ?? $model->$field }}">
            @continue
        @endif

        <div class="form-group row">
            <label for="{{ $field }}" class="col-md-4 col-form-label text-md-right">
                {{ trans("headers.$slug.$field") }}
            </label>

            <div class="col-md-6">
                @php($type = field_type($field))
                <input id="{{ $field }}" type="{{ $type }}" value="{{ old($field) ?? $model->$field }}"
                       class="form-control @error($field) is-invalid @enderror"
                       name="{{ $field }}" autocomplete="{{ $field }}">

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
