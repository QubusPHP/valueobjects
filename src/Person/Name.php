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

namespace Qubus\ValueObjects\Person;

use BadMethodCallException;
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
     */
    public function __toString(): string
    {
        return strval($this->getFullName());
    }

    /**
     * Returns a Name objects form PHP native values.
     *
     * @param string ...$args
     * @return Name|ValueObject
     */
    public static function fromNative(string ...$args): Name|ValueObject
    {
        if (3 !== count($args)) {
            throw new BadMethodCallException(
                'You must provide exactly 3 arguments: 1) first name, 2) middle name, 3) last name.'
            );
        }

        $firstName = new StringLiteral($args[0]);
        $middleName = new StringLiteral($args[1]);
        $lastName = new StringLiteral($args[2]);

        return new self($firstName, $middleName, $lastName);
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
     * @param ValueObject $name
     * @return bool
     */
    public function equals(ValueObject $name): bool
    {
        if (false === Util::classEquals($this, $name)) {
            return false;
        }

        return $this->toNative() === $name->toNative();
    }

    public function toNative(): string
    {
        return $this->getFullName()->toNative();
    }
}
