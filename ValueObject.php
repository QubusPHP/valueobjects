<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects;

interface ValueObject
{
    /**
     * Returns a object taking PHP native value(s) as argument(s).
     */
    public static function fromNative(): ValueObject;

    /**
     * Compare two ValueObject and tells whether they can be considered equal
     */
    public function equals(ValueObject $object): bool;

    /**
     * Returns a string representation of the object
     */
    public function __toString(): string;
}
