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

namespace Qubus\ValueObjects\Structure;

use BadMethodCallException;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function count;
use function func_get_args;
use function sprintf;
use function strval;

class KeyValuePair implements ValueObject
{
    /**
     * Returns a KeyValuePair.
     */
    public function __construct(
        protected ValueObject $key,
        protected ValueObject $value
    ) {
    }

    /**
     * Returns a string representation of the KeyValuePair in format "$key => $value".
     */
    public function __toString(): string
    {
        return sprintf('%s => %s', $this->getKey(), $this->getValue());
    }

    /**
     * Returns a KeyValuePair from native PHP arguments evaluated as strings.
     *
     * @param string $key
     * @param string $value
     * @return KeyValuePair|ValueObject
     * @throws TypeException
     * @throws BadMethodCallException
     */
    public static function fromNative(): KeyValuePair|ValueObject
    {
        $args = func_get_args();

        if (2 !== count($args)) {
            throw new BadMethodCallException(
                'This methods expects two arguments. One for the key and one for the value.'
            );
        }

        $keyString = strval($args[0]);
        $valueString = strval($args[1]);
        $key = new StringLiteral($keyString);
        $value = new StringLiteral($valueString);

        return new static($key, $value);
    }

    /**
     * Tells whether two KeyValuePair are equal.
     *
     * @param KeyValuePair|ValueObject $keyValuePair
     * @return bool
     */
    public function equals(KeyValuePair|ValueObject $keyValuePair): bool
    {
        if (false === Util::classEquals($this, $keyValuePair)) {
            return false;
        }

        return $this->getKey()->equals($keyValuePair->getKey())
        && $this->getValue()->equals($keyValuePair->getValue());
    }

    /**
     * Returns key.
     */
    public function getKey(): ValueObject
    {
        return clone $this->key;
    }

    /**
     * Returns value.
     */
    public function getValue(): ValueObject
    {
        return clone $this->value;
    }
}
