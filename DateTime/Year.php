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

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\IntegerNumber;

use function intval;

class Year extends IntegerNumber
{
    /**
     * Returns the current year.
     * @throws TypeException
     */
    public static function now(): Year
    {
        $now = new CarbonImmutable('now');

        return new static(intval($now->format('Y')));
    }
}
