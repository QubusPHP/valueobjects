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

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\ValueObjects\Number\Integer;

use function intval;

class Year extends Integer
{
    /**
     * Returns the current year.
     */
    public static function now(): Year
    {
        $now = new CarbonImmutable('now');

        return new static(intval($now->format('Y')));
    }
}
