<?php

namespace App\Services;

class MetaService
{
    private ?string $title = '';
    private ?string $description = '';
    private ?string $keywords = '';

    public function __construct(string $title) {
        $this->title = $title;
    }

    public function __get(string $property): ?string {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public static function each(string $value): self
    {
        return (new self($value))->description($value)->keywords($value);
    }

    public static function title(string $value): self
    {
        return new self($value);
    }

    public function description(?string $value): self
    {
        $this->description = $value;

        return $this;
    }

    public function keywords(?string $value): self
    {
        $this->keywords = $value;

        return $this;
    }
}
