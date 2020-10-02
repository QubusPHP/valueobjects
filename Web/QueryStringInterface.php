<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\ValueObjects\Structure\Dictionary;

interface QueryStringInterface
{
    /**
     * @return Dictionary
     */
    public function toDictionary(): Dictionary;
}
