<?php

namespace App\Models\Traits;

trait HasAttributeAliases
{
    /**
     * Map alias attribute names to real database column names.
     *
     * @var array<string, string>
     */
    protected array $attributeAliases = [];

    public function getAttribute($key)
    {
        $key = $this->resolveAlias($key);

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        $key = $this->resolveAlias($key);

        return parent::setAttribute($key, $value);
    }

    protected function resolveAlias(string $key): string
    {
        return $this->attributeAliases[$key] ?? $key;
    }
}
