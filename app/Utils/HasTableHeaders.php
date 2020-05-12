<?php

namespace App\Utils;

trait HasTableHeaders
{
    public static function getHeaders()
    {
        $class = static::getModelSlug();
        $result = [];

        foreach (static::$headers ?? [] as $key => $value) {
            $result["headers.$class.$key"] = $value;
        }

        return $result;
    }

    public static function getModelSlug()
    {
        /** @var Slug|null $slug */
        static $slug = null;

        return $slug ??= Slug::fromModel(static::class);
    }
}
