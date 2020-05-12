<?php /** @var \App\Utils\Slug $slug */ ?>
<?php /** @var \App\Model $model */ ?>

<form>
    @foreach($model->getFillable() as $field)
        @if(\Str::endsWith($field, '_id'))
            @continue
        @endif

        <div class="form-group row">
            <label for="{{ $field }}" class="col-md-4 col-form-label text-md-right">
                {{ trans("headers.$slug.$field") }}
            </label>

            <div class="col-md-6">
                @php($type = field_type($field))
                @if($type === 'checkbox')
                    <input id="{{ $field }}" type="text" readonly class="form-control"
                           value="{{ $model[$field] ? __('Igen') : __('Nem') }}">
                @elseif($type === 'password')
                    <input id="{{ $field }}" type="{{ $type }}" readonly
                           class="form-control">
                @else
                    <input id="{{ $field }}" type="{{ $type }}" readonly
                           value="{{ $model[$field] }}" class="form-control">
                @endif
            </div>
        </div>
    @endforeach
</form>
