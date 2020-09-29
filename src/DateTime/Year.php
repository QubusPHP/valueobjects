<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\ValueObjects\Number\Integer;

/**
 * Class Year.
 */
class Year extends Integer
{
    /**
     * Returns the current year.
     *
     * @return Year
     */
    public static function now(): Year
    {
        $now = new CarbonImmutable('now');

        return new static(intval($now->format('Y')));
    }
}
