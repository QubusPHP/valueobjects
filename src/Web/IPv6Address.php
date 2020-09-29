<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\ValueObjects\Web\IPAddress;
use Qubus\Exception\Data\TypeException;

class IPv6Address extends IPAddress
{
    /**
     * Returns a new IPv6Address
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $filteredValue = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);

        if (false === $filteredValue) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter a string (valid ipv6 address).',
                    $value
                )
            );
        }

        $this->value = $filteredValue;
    }
}
