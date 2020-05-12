<?php

if (! function_exists('table_value')) {
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $path
     * @return string
     */
    function table_value($model, $path)
    {
        $value = data_get($model, $path);

        if (is_bool($value)) {
            return $value ? __('Igen') : __('Nem');
        }

        if ($model instanceof \App\Invoice && $path === 'status') {
            return \Lang::get("invoices.status.$value");
        }

        return (string) $value;
    }
}

if (! function_exists('field_type')) {
    /**
     * @param string $field
     * @return string
     */
    function field_type($field)
    {
        if (Str::endsWith($field, '_at')) {
            return 'date';
        }

        if (Str::startsWith($field, 'is_')) {
            return 'checkbox';
        }

        if (Str::contains($field, 'email')) {
            return 'email';
        }

        return $field === 'password' ? $field : 'text';
    }
}
