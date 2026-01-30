<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020
 * @author     Joshua Parker <joshua@joshuaparker.dev>
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

namespace Qubus\ValueObjects;

/**
 * Utility class for methods used all across the framework.
 */
class Util
{
    /**
     * Tells whether two objects are of the same class
     */
    public static function classEquals(object $objectA, object $objectB): bool
    {
        return $objectA::class === $objectB::class;
    }

    /**
     * Returns full namespaced class as string
     */
    public static function getClassAsString(object $object): string
    {
        return $object::class;
    }
}
