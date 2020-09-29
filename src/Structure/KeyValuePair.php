<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Structure;

use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObjectInterface;
use Qubus\ValueObjects\StringLiteral\StringLiteral;

class KeyValuePair implements ValueObjectInterface
{
    /**
     * @var ValueObjectInterface
     */
    protected ValueObjectInterface $key;

    /**
     * @var ValueObjectInterface
     */
    protected ValueObjectInterface $value;

    /**
     * Returns a KeyValuePair.
     *
     * @param ValueObjectInterface $key
     * @param ValueObjectInterface $value
     */
    public function __construct(
        ValueObjectInterface $key,
        ValueObjectInterface $value
    ) {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Returns a string representation of the KeyValuePair in format "$key => $value".
     *
     * @return string
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
     *
     * @throws \BadMethodCallException
     *
     * @return KeyValuePair|ValueObjectInterface
     * @return KeyValuePair|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        if (2 != count($args)) {
            throw new \BadMethodCallException('This methods expects two arguments. One for the key and one for the value.');
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
     * @param KeyValuePair|ValueObjectInterface $keyValuePair
     *
     * @return bool
     */
    public function equals(ValueObjectInterface $keyValuePair): bool
    {
        if (false === Util::classEquals($this, $keyValuePair)) {
            return false;
        }

        return $this->getKey()->equals($keyValuePair->getKey())
            && $this->getValue()->equals($keyValuePair->getValue());
    }

    /**
     * Returns key.
     *
     * @return ValueObjectInterface
     */
    public function getKey(): ValueObjectInterface
    {
        return clone $this->key;
    }

    /**
     * Returns value.
     *
     * @return ValueObjectInterface
     */
    public function getValue(): ValueObjectInterface
    {
        return clone $this->value;
    }
}
