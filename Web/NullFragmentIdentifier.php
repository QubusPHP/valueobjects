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

use Qubus\ValueObjects\Web\FragmentIdentifier;
use Qubus\ValueObjects\Web\UrlFragmentIdentifier;

class NullFragmentIdentifier extends UrlFragmentIdentifier implements FragmentIdentifier
{
    /**
     * Returns a new NullFragmentIdentifier.
     */
    public function __construct()
    {
        $this->value = '';
    }
}
