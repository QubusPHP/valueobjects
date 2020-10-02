<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Datetime\Exceptions;

/**
 * Class InvalidDateException.
 */
final class InvalidDateException extends \Exception
{
    /**
     * InvalidDateException constructor.
     *
     * @param $year
     * @param $month
     * @param $day
     */
    public function __construct($year, $month, $day)
    {
        $date = sprintf('%d-%d-%d', $year, $month, $day);
        $message = sprintf('The date "%s" is invalid.', $date);
        parent::__construct($message);
    }
}
