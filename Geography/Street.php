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

use function array_keys;
use function array_values;
use function count;
use function func_get_args;
use function str_replace;

class Street implements ValueObject
{
    protected StringLiteral $name;

    protected StringLiteral $number;

    /** @var StringLiteral Building, floor and unit */
    protected StringLiteral $elements;

    /**
     * @var StringLiteral __toString() format
     *                    Use properties corresponding placeholders: %name%, %number%, %elements%
     */
    protected StringLiteral $format;

    /**
     * Returns a new Street object.
     */
    public function __construct(
        StringLiteral $name,
        StringLiteral $number,
        ?StringLiteral $elements = null,
        ?StringLiteral $format = null
    ) {
        $this->name = $name;
        $this->number = $number;

        if (null === $elements) {
            $elements = new StringLiteral('');
        }
        $this->elements = $elements;

        if (null === $format) {
            $format = new StringLiteral('%number% %name%');
        }
        $this->format = $format;
    }

    /**
     * Returns a string representation of the StringLiteral in the format defined in the constructor.
     */
    public function __toString(): string
    {
        $replacements = [
            '%name%'     => $this->getName(),
            '%number%'   => $this->getNumber(),
            '%elements%' => $this->getElements(),
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $this->format);
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
                'You must provide from 2 to 4 arguments: 1) street name, 2) street number, 
                3) elements, 4) format (optional)'
            );
        }

        $nameString = $args[0];
        $numberString = $args[1];
        $elementsString = $args[2] ?? '';
        $formatString = $args[3] ?? '';

        $name = new StringLiteral($nameString);
        $number = new StringLiteral($numberString);
        $elements = $elementsString ? new StringLiteral($elementsString) : null;
        $format = $formatString ? new StringLiteral($formatString) : null;

        return new static($name, $number, $elements, $format);
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
        $this->getNumber()->equals($street->getNumber()) &&
        $this->getElements()->equals($street->getElements());
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

    /**
     * Returns street elements.
     */
    public function getElements(): StringLiteral
    {
        return clone $this->elements;
    }
}
