<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\ValueObjects\NullValue\NullValue;
use Qubus\ValueObjects\Web\PortNumberInterface;

class NullPortNumber extends NullValue implements PortNumberInterface
{
}
