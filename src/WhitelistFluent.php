<?php

declare(strict_types=1);

namespace Jfcherng\Utility;

class WhitelistFluent implements \ArrayAccess, \JsonSerializable
{
    /**
     * All of the attributes set on the container.
     *
     * Child classes should override this propery.
     */
    protected array $attributes = [
        // key => (default) value
    ];

    /**
     * Names of the attributes.
     *
     * Used to utilize isset() to check attribute availability.
     *
     * @var array<string,bool>
     */
    protected array $cachedAllowedAttributeNames = [
        // attribute name => true
    ];

    /**
     * Create a new fluent container instance.
     */
    public function __construct(iterable $attributes = [])
    {
        $this
            ->updateCachedAllowedAttributeNames()
            ->init()
        ;

        foreach ($attributes as $key => $value) {
            $this->offsetSet($key, $value);
        }
    }

    /**
     * Handle dynamic calls to the container to set attributes.
     *
     * @param string $method
     * @param array  $parameters
     */
    public function __call($method, $parameters): static
    {
        $this->offsetSet($method, \count($parameters) > 0 ? $parameters[0] : true);

        return $this;
    }

    /**
     * Dynamically retrieve the value of an attribute.
     *
     * @param string $key
     */
    public function __get($key): mixed
    {
        return $this->get($key);
    }

    /**
     * Dynamically set the value of an attribute.
     */
    public function __set(string $key, mixed $value): void
    {
        $this->offsetSet($key, $value);
    }

    /**
     * Dynamically check if an attribute is set.
     *
     * @param string $key
     */
    public function __isset($key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * Dynamically unset an attribute.
     */
    public function __unset(string $key): void
    {
        $this->offsetUnset($key);
    }

    /**
     * Get an attribute from the container.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        if (isset($this->cachedAllowedAttributeNames[$key])) {
            return $this->attributes[$key];
        }

        return \is_callable($default) ? $default() : $default;
    }

    /**
     * Get the attributes from the container.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Get names of allowed attributes.
     *
     * @return array names of allowed attributes
     */
    public function getAllowedAttributes(): array
    {
        return array_keys($this->attributes);
    }

    /**
     * Get the value for a given offset.
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * Set the value at the given offset.
     *
     * @throws \InvalidArgumentException if want to set an invalid attribute
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!isset($this->cachedAllowedAttributeNames[$offset])) {
            throw new \InvalidArgumentException(static::class . " does not allowed attribute `{$offset}`. Allowed: " . implode(', ', $this->getAllowedAttributes()));
        }

        $this->attributes[$offset] = $value;
    }

    /**
     * Unset the value at the given offset.
     */
    public function offsetUnset(mixed $offset): void
    {
        try {
            $this->offsetSet($offset, null);
        } catch (\Exception $e) {
            // be safe just like unset() even with an invalid attribute
        }
    }

    /**
     * Determine if the given offset exists.
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->cachedAllowedAttributeNames[$offset]);
    }

    /**
     * Convert the Fluent instance to an array.
     */
    public function toArray(): array
    {
        return $this->getAttributes();
    }

    /**
     * Convert the Fluent instance to JSON.
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Convert the object into something JSON serializable.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Initiate this object.
     *
     * This method could be overriden to init objects for attributes.
     * You have to call updateCachedAllowedAttributeNames() if you add/remove an attribute.
     */
    protected function init(): static
    {
        return $this;
    }

    /**
     * Update the cachedAllowedAttributeNames.
     */
    protected function updateCachedAllowedAttributeNames(): static
    {
        $this->cachedAllowedAttributeNames = array_fill_keys(
            $this->getAllowedAttributes(),
            true,
        );

        return $this;
    }
}
