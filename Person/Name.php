<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020
 * @author     Joshua Parker <joshua@joshuaparker.dev>
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Person;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function func_get_args;
use function strval;

class Name implements ValueObject
{
    /**
     * Returns a Name object.
     */
    public function __construct(
        protected StringLiteral $firstName,
        protected StringLiteral $middleName,
        protected StringLiteral $lastName
    ) {
    }

    /**
     * Returns the full name.
     * @throws TypeException
     */
    public function __toString(): string
    {
        return strval($this->getFullName());
    }

    /**
     * Returns a Name objects form PHP native values.
     *
     * @param string $first_name
     * @param string $middle_name
     * @param string $last_name
     * @return Name|ValueObject
     * @throws TypeException
     */
    public static function fromNative(): Name|ValueObject
    {
        $args = func_get_args();

        $firstName = new StringLiteral($args[0]);
        $middleName = new StringLiteral($args[1]);
        $lastName = new StringLiteral($args[2]);

        return new static($firstName, $middleName, $lastName);
    }

    /**
     * Returns the first name.
     */
    public function getFirstName(): StringLiteral
    {
        return $this->firstName;
    }

    /**
     * Returns the middle name.
     */
    public function getMiddleName(): StringLiteral
    {
        return $this->middleName;
    }

    /**
     * Returns the last name.
     */
    public function getLastName(): StringLiteral
    {
        return $this->lastName;
    }

    /**
     * Returns the full name.
     * @throws TypeException
     */
    public function getFullName(): StringLiteral
    {
        $fullNameString = $this->firstName
        . ($this->middleName->isEmpty() ? '' : ' ' . $this->middleName)
        . ($this->lastName->isEmpty() ? '' : ' ' . $this->lastName);

        return new StringLiteral($fullNameString);
    }

    /**
     * Tells whether two names are equal by comparing their values.
     *
     * @param Name|ValueObject $name
     * @return bool
     * @throws TypeException
     */
    public function equals(Name|ValueObject $name): bool
    {
        if (false === Util::classEquals($this, $name)) {
            return false;
        }

        return strval($this->getFullName()) === strval($name->getFullName());
    }
}
