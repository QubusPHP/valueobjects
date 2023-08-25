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

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\Natural;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;
use SplFixedArray;
use Traversable;

use function func_get_arg;
use function gettype;
use function is_array;
use function is_object;
use function sprintf;
use function strval;

class Collection implements ValueObject
{
    /**
     * Returns a new Collection object.
     * @throws TypeException
     */
    public function __construct(protected SplFixedArray $items)
    {
        foreach ($items as $item) {
            if (false === $item instanceof ValueObject) {
                $type = is_object($item) ? $item::class : gettype($item);

                throw new TypeException(
                    sprintf(
                        'Passed SplFixedArray object must contains "ValueObject" objects only. "%s" given.',
                        $type
                    )
                );
            }
        }

        $this->items = $items;
    }

    /**
     * Returns a native string representation of the Collection object.
     */
    public function __toString(): string
    {
        return sprintf('%s(%d)', static::class, $this->count()->toNative());
    }

    /**
     * Returns a new Collection object.
     *
     * @param ...SplFixedArray $array
     * @return Collection|ValueObject
     * @throws TypeException
     */
    public static function fromNative(): Collection|ValueObject
    {
        $array = func_get_arg(0);
        $items = [];

        foreach ($array as $item) {
            if ($item instanceof Traversable || is_array($item)) {
                $items[] = static::fromNative($item);
            } else {
                $items[] = new StringLiteral(strval($item));
            }
        }

        return new static(SplFixedArray::fromArray($items));
    }

    /**
     * Tells whether two Collection are equal by comparing their size and items (item order matters).
     *
     * @param Collection|ValueObject $collection
     * @return bool
     * @throws TypeException
     */
    public function equals(Collection|ValueObject $collection): bool
    {
        if (
            false === Util::classEquals($this, $collection)
            || false === $this->count()->equals($collection->count())
        ) {
            return false;
        }

        $arrayCollection = $collection->toArray();

        foreach ($this->items as $index => $item) {
            if (! isset($arrayCollection[$index]) || false === $item->equals($arrayCollection[$index])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the number of objects in the collection.
     * @throws TypeException
     */
    public function count(): Natural
    {
        return new Natural($this->items->count());
    }

    /**
     * Tells whether the Collection contains an object.
     */
    public function contains(ValueObject $object): bool
    {
        foreach ($this->items as $item) {
            if ($item->equals($object)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns a native array representation of the Collection.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->items->toArray();
    }
}
