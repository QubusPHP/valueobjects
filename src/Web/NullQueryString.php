<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\ValueObjects\Web\QueryString;
use Qubus\ValueObjects\Web\QueryStringInterface;

class NullQueryString extends QueryString implements QueryStringInterface
{
    /**
     * Returns a new NullQueryString.
     */
    public function __construct()
    {
        $this->value = '';
    }
}
