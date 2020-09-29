<?php

declare(strict_types=1);

namespace Qubus\ValueObjects;

interface ValueObjectInterface
{
    /**
     * Returns a object taking PHP native value(s) as argument(s).
     *
     * @return ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface;

    /**
     * Compare two ValueObjectInterface and tells whether they can be considered equal
     *
     * @param  ValueObjectInterface $object
     * @return bool
     */
    public function equals(ValueObjectInterface $object): bool;

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function __toString(): string;
}
