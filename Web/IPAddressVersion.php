<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\ValueObjects\Enum\Enum;

class IPAddressVersion extends Enum
{
    const IPV4 = 'IPv4';
    const IPV6 = 'IPv6';
}
