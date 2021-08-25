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

use Laminas\Validator\Hostname as Validator;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Web\Domain;

use function sprintf;

class Hostname extends Domain
{
    /**
     * Returns a Hostname
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
