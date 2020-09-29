<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Datetime\Exceptions;

/**
 * Class InvalidTimeZoneException.
 */
final class InvalidTimeZoneException extends \Exception
{
    public function __construct($name)
    {
        $message = sprintf('The timezone "%s" is invalid. Check "timezone_identifiers_list()" for valid values.', $name);
        parent::__construct($message);
    }
}
