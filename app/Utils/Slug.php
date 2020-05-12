<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
use Str;

/** @property-read string|null $prefix */
class Slug
{
    public $model;

    protected $slug;

    /** @var int|null */
    protected $organization;

    public function __construct(string $model)
    {
        $this->model = $model;
        $this->slug = Str::snake(class_basename($model));
    }

    public function model(): Model
    {
        $class = $this->model;

        return new $class();
    }

    public function organization()
    {
        $organization = $this->organization;

        return $organization !== null ? compact('organization') : [];
    }

    public function setOrganization(int $organization)
    {
        $this->organization = $organization;
    }

    public function __invoke(Model $model): array
    {
        return [Str::singular($this->slug) => $model] + $this->organization();
    }

    public function __toString()
    {
        return Str::plural($this->slug);
    }

    /** @noinspection MagicMethodsValidityInspection */
    public function __get($name)
    {
        $result = null;

        if ($name === 'prefix') {
            $result = $this->organization !== null
                ? "organizations.$this"
                : (string) $this;
        }

        return $result;
    }

    /**
     * @param string $class
     * @return static
     */
    public static function fromModel(string $class)
    {
        return new static($class);
    }
}
