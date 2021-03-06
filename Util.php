<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020 Joshua Parker
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects;

use function get_class;

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
        return get_class($objectA) === get_class($objectB);
    }

    /**
     * Returns full namespaced class as string
     */
    public static function getClassAsString(object $object): string
    {
        return get_class($object);
    }
}
