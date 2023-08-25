<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020
 * @author     Joshua Parker <joshua@joshuaparker.dev>
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;

use function explode;
use function filter_var;
use function sprintf;
use function trim;

use const FILTER_VALIDATE_EMAIL;

class EmailAddress extends StringLiteral
{
    /**
     * Returns an EmailAddress object given a PHP native string as parameter.
     * @throws TypeException
     */
    public function __construct(string $value)
    {
        $filteredValue = filter_var($value, FILTER_VALIDATE_EMAIL);

        if (false === $filteredValue) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter a string (valid email address).',
                    $value
                )
            );
        }

        $this->value = $filteredValue;
    }

    /**
     * Returns the local part of the email address
     * @throws TypeException
     */
    public function getLocalPart(): StringLiteral
    {
        $parts = explode('@', $this->toNative());

        return new StringLiteral($parts[0]);
    }

    /**
     * Returns the domain part of the email address
     * @throws TypeException
     */
    public function getDomainPart(): Domain
    {
        $parts = explode('@', $this->toNative());
        $domain = trim($parts[1], '[]');

        return Domain::specifyType($domain);
    }
}
