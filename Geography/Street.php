<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020 Joshua Parker
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Geography;

use BadFunctionCallException;
use BadMethodCallException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function count;
use function func_get_args;
use function sprintf;

class Street implements ValueObject
{
    /**
     * Returns a new Street object.
     */
    public function __construct(
        protected StringLiteral $name,
        protected StringLiteral $number,
    ) {
    }

    /**
     * Returns a string representation of the StringLiteral in the format defined in the constructor.
     */
    public function __toString(): string
    {
        return sprintf('%s %s', $this->getNumber(), $this->getName());
    }

    /**
     * Returns a new Street from native PHP string name and number.
     *
     * @param string $name
     * @param string $number
     * @param string $elements
     * @throws BadFunctionCallException
     * @return Street|ValueObject
     */
    public static function fromNative(): ValueObject
    {
        $args = func_get_args();

        if (count($args) < 2) {
            throw new BadMethodCallException(
                'You must provide exactly 2 arguments: 1) street name, 2) street number.'
            );
        }

        $nameString   = $args[0];
        $numberString = $args[1];

        $name   = new StringLiteral($nameString);
        $number = new StringLiteral($numberString);

        return new self($name, $number);
    }

    /**
     * Tells whether two Street objects are equal.
     *
     * @param Street|ValueObject $street
     */
    public function equals(ValueObject $street): bool
    {
        if (false === Util::classEquals($this, $street)) {
            return false;
        }

        return $this->getName()->equals($street->getName()) &&
        $this->getNumber()->equals($street->getNumber());
    }

    /**
     * Returns street name.
     */
    public function getName(): StringLiteral
    {
        return clone $this->name;
    }

    /**
     * Returns street number.
     */
    public function getNumber(): StringLiteral
    {
        return clone $this->number;
    }
}
