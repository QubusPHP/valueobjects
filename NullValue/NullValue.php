<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\NullValue;

use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObjectInterface;

class NullValue implements ValueObjectInterface
{
    /**
     * @throws \BadMethodCallException
     */
    public static function fromNative(): ValueObjectInterface
    {
        throw new \BadMethodCallException('Cannot create a NullValue object via this method.');
    }

    /**
     * Returns a new Null object
     *
     * @return NullValue|ValueObjectInterface
     */
    public static function create(): ValueObjectInterface
    {
        return new static();
    }

    /**
     * Tells whether two objects are both Null.
     *
     * @param  ValueObjectInterface $null
     * @return bool
     */
    public function equals(ValueObjectInterface $null): bool
    {
        return Util::classEquals($this, $null);
    }

    /**
     * Returns a string representation of the Null object
     *
     * @return string
     */
    public function __toString(): string
    {
        return strval(null);
    }
}
