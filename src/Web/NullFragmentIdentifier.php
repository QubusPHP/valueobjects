<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\ValueObjects\Web\FragmentIdentifier;
use Qubus\ValueObjects\Web\FragmentIdentifierInterface;

class NullFragmentIdentifier extends FragmentIdentifier implements FragmentIdentifierInterface
{
    /**
     * Returns a new NullFragmentIdentifier.
     */
    public function __construct()
    {
        $this->value = '';
    }
}
