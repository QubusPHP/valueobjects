<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\ValueObjects\Enum\Enum;

class IPAddressVersion extends Enum
{
    public const IPV4 = 'IPv4';
    public const IPV6 = 'IPv6';
}
