<?php

namespace App\Utils;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Str;

class ForeignHandler
{
    protected $builder;

    public function __construct(Closure $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param string $name
     * @return Builder
     */
    public function relation($name)
    {
        /** @var Builder $builder */
        $builder = ($this->builder)();

        $name = $this->withoutId($name);

        if (! method_exists($builder, $name)) {
            $name = Str::plural($name);
        }

        return method_exists($builder, $name)
            ? $builder->{$name}()
            : $builder;
    }

    public function headers($name): array
    {
        $name = $this->withoutId($name);

        return ('App\\' . Str::studly($name) . '::getHeaders')();
    }

    protected function withoutId($name): string
    {
        $name = Str::endsWith($name, '_id') ? substr($name, 0, -3) : $name;
        return Str::camel($name);
    }
}
