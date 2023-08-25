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

use Stringable;

interface ValueObject extends Stringable
{
    /**
     * Returns a object taking PHP native value(s) as argument(s).
     */
    public static function fromNative(): ValueObject;

    /**
     * Compare two ValueObject and tells whether they can be considered equal
     */
    public function equals(ValueObject $object): bool;
}
