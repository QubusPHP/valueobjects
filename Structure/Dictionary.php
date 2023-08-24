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

namespace Qubus\ValueObjects\Structure;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\ValueObject;
use SplFixedArray;
use Traversable;

use function func_get_arg;
use function gettype;
use function is_array;
use function is_object;
use function sprintf;
use function strval;

class Dictionary extends Collection
{
    /**
     * Returns a new Dictionary object.
     *
     * @param SplFixedArray $pairs
     * @throws TypeException
     */
    public function __construct(SplFixedArray $pairs)
    {
        foreach ($pairs as $keyValuePair) {
            if (false === $keyValuePair instanceof KeyValuePair) {
                $type = is_object($keyValuePair) ? $keyValuePair::class : gettype($keyValuePair);

                throw new TypeException(
                    sprintf(
                        'Passed SplFixedArray object must contains "KeyValuePair" objects only. "%s" given.',
                        $type
                    )
                );
            }
        }

        $this->items = $pairs;
    }

    /**
     * Returns a new Dictionary object.
     *
     * @param ...array $array
     * @return Dictionary|ValueObject
     * @throws TypeException
     */
    public static function fromNative(): Dictionary|ValueObject
    {
        $array = func_get_arg(0);
        $keyValuePairs = [];

        foreach ($array as $arrayKey => $arrayValue) {
            $key = new StringLiteral(strval($arrayKey));

            if ($arrayValue instanceof Traversable || is_array($arrayValue)) {
                $value = Collection::fromNative($arrayValue);
            } else {
                $value = new StringLiteral(strval($arrayValue));
            }
            $keyValuePairs[] = new KeyValuePair($key, $value);
        }

        return new static(SplFixedArray::fromArray($keyValuePairs));
    }

    /**
     * Returns a Collection of the keys.
     * @throws TypeException
     */
    public function keys(): Collection
    {
        $count = $this->count()->toNative();
        $keysArray = new SplFixedArray($count);

        foreach ($this->items as $key => $item) {
            $keysArray->offsetSet($key, $item->getKey());
        }

        return new Collection($keysArray);
    }

    /**
     * Returns a Collection of the values.
     * @throws TypeException
     */
    public function values(): Collection
    {
        $count = $this->count()->toNative();
        $valuesArray = new SplFixedArray($count);

        foreach ($this->items as $key => $item) {
            $valuesArray->offsetSet($key, $item->getValue());
        }

        return new Collection($valuesArray);
    }

    /**
     * Tells whether $object is one of the keys.
     * @throws TypeException
     */
    public function containsKey(ValueObject $object): bool
    {
        $keys = $this->keys();

        return $keys->contains($object);
    }

    /**
     * Tells whether $object is one of the values.
     * @throws TypeException
     */
    public function containsValue(ValueObject $object): bool
    {
        $values = $this->values();

        return $values->contains($object);
    }
}
