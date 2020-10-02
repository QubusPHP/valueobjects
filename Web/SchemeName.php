<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;

class SchemeName extends StringLiteral
{
    /**
     * Returns a SchemeName.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (0 === preg_match('/^[a-z]([a-z0-9\+\.-]+)?$/i', $value)) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter a string (valid scheme name).',
                    $value
                )
            );
        }

        $this->value = $value;
    }
}
