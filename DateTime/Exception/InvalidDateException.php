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

namespace Qubus\ValueObjects\DateTime\Exception;

use Qubus\Exception\Exception;
use Qubus\ValueObjects\DateTime\Month;
use Qubus\ValueObjects\DateTime\MonthDay;
use Qubus\ValueObjects\DateTime\Year;

use function sprintf;

final class InvalidDateException extends Exception
{
    /**
     * @param Year $year
     * @param Month $month
     * @param MonthDay $day
     */
    public function __construct($year, $month, $day)
    {
        $date = sprintf('%d-%d-%d', $year, $month, $day);
        $message = sprintf('The date "%s" is invalid.', $date);
        parent::__construct($message);
    }
}
