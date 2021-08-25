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

use Qubus\ValueObjects\Structure\Dictionary;

interface QueryString
{
    public function toDictionary(): Dictionary;
}
