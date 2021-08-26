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

use Qubus\ValueObjects\NullValue\NullValue;
use Qubus\ValueObjects\Web\PortNumber;

class NullPortNumber extends NullValue implements PortNumber
{
}
