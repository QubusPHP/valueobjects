<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Number;

use Qubus\ValueObjects\Number\Integer;
use Qubus\Exception\Data\TypeException;

class Natural extends Integer
{
    /**
     * Returns a Natural object given a PHP native int as parameter.
     *
     * @param int $value
     */
    public function __construct($value)
    {
        $options = [
            'options' => [
                'min_range' => 0
            ]
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must be an integer (>=0).',
                    $value
                )
            );
        }

        parent::__construct($value);
    }
}
