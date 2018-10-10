<?php

namespace Jfcherng\Utility;

use ArrayAccess;
use Exception;
use InvalidArgumentException;
use JsonSerializable;

class WhitelistFluent implements ArrayAccess, JsonSerializable
{
    /**
     * All of the attributes set on the container.
     *
     * Child classes should override this propery.
     *
     * @var array
     */
    protected $attributes = [
        // key => (default) value
    ];

    /**
     * Names of the attributes.
     *
     * Used to utilize isset() to check attribute availability.
     *
     * @var array
     */
    protected $cachedAllowedAttributeNames = [
        // attribute name => true
    ];

    /**
     * Create a new fluent container instance.
     *
     * @param iterable $attributes
     */
    public function __construct($attributes = [])
    {
        $this
            ->updateCachedAllowedAttributeNames()
            ->init();

        foreach ($attributes as $key => $value) {
            $this->offsetSet($key, $value);
        }
    }

    /**
     * Handle dynamic calls to the container to set attributes.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return self
     */
    public function __call($method, $parameters)
    {
        $this->offsetSet($method, \count($parameters) > 0 ? $parameters[0] : true);

        return $this;
    }

    /**
     * Dynamically retrieve the value of an attribute.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Dynamically set the value of an attribute.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function __set($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    /**
     * Dynamically check if an attribute is set.
     *
     * @param string $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Dynamically unset an attribute.
     *
     * @param string $key
     */
    public function __unset($key)
    {
        $this->offsetUnset($key);
    }

    /**
     * Get an attribute from the container.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (isset($this->cachedAllowedAttributeNames[$key])) {
            return $this->attributes[$key];
        }

        return \is_callable($default) ? $default() : $default;
    }

    /**
     * Get the attributes from the container.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get names of allowed attributes.
     *
     * @return array names of allowed attributes
     */
    public function getAllowedAttributes()
    {
        return \array_keys($this->attributes);
    }

    /**
     * Get the value for a given offset.
     *
     * @param string $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Set the value at the given offset.
     *
     * @param string $offset
     * @param mixed  $value
     *
     * @throws InvalidArgumentException if want to set an invalid attribute
     */
    public function offsetSet($offset, $value)
    {
        if (!isset($this->cachedAllowedAttributeNames[$offset])) {
            throw new InvalidArgumentException(
                __CLASS__ .
                " does not allowed attribute `{$offset}`. Allowed: " .
                \implode(', ', $this->getAllowedAttributes())
            );
        }

        $this->attributes[$offset] = $value;
    }

    /**
     * Unset the value at the given offset.
     *
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        try {
            $this->offsetSet($offset, null);
        } catch (Exception $e) {
            // be safe just like unset() even with an invalid attribute
        }
    }

    /**
     * Determine if the given offset exists.
     *
     * @param string $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->cachedAllowedAttributeNames[$offset]);
    }

    /**
     * Convert the Fluent instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getAttributes();
    }

    /**
     * Convert the Fluent instance to JSON.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return \json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Initiate this object.
     *
     * This method could be overriden to init objects for attributes.
     * You have to call updateCachedAllowedAttributeNames() if you add/remove an attribute.
     *
     * @return self
     */
    protected function init()
    {
        return $this;
    }

    /**
     * Update the cachedAllowedAttributeNames.
     *
     * @return self
     */
    protected function updateCachedAllowedAttributeNames()
    {
        $this->cachedAllowedAttributeNames = \array_fill_keys(
            $this->getAllowedAttributes(),
            true
        );

        return $this;
    }
}
