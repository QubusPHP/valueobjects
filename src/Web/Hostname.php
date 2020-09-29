<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\Exception\Data\TypeException;
use Laminas\Validator\Hostname as Validator;
use Qubus\ValueObjects\Web\Domain;

class Hostname extends Domain
{
    /**
     * Returns a Hostname
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $validator = new Validator(['allow' => Validator::ALLOW_DNS | Validator::ALLOW_LOCAL]);

        if (false === $validator->isValid($value)) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter a string (valid hostname).',
                    $value
                )
            );
        }

        $this->value = $value;
    }
}
