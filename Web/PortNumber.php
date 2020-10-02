<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\ValueObjects\Number\Natural;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Web\PortNumberInterface;

class PortNumber extends Natural implements PortNumberInterface
{
    /**
     * Returns a PortNumber object.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => [
                'min_range' => 0,
                'max_range' => 65535,
            ],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter an integer (>=0, <=65535).',
                    $value
                )
            );
        }

        parent::__construct($value);
    }
}
