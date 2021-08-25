<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime\Exception;

use Qubus\Exception\Exception;

use function sprintf;

final class InvalidTimeZoneException extends Exception
{
    public function __construct($name)
    {
        $message = sprintf(
            'The timezone "%s" is invalid. Check "timezone_identifiers_list()" for valid values.',
            $name
        );
        parent::__construct($message);
    }
}
