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

namespace Qubus\ValueObjects\Enum;

use MabeEnum\Enum as BaseEnum;
use MabeEnum\EnumSerializableTrait;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;
use Serializable;

use function func_get_arg;
use function strval;

abstract class Enum extends BaseEnum implements ValueObject, Serializable
{
    use EnumSerializableTrait;

    /**
     * Returns a new Enum object from passed value matching argument
     *
     * @param  string $value
     * @return static
     */
    public static function fromNative(): ValueObject
    {
        return static::get(func_get_arg(0));
    }

    /**
     * Returns the PHP native value of the enum
     *
     * @return mixed
     */
    public function toNative(): mixed
    {
        return parent::getValue();
    }

    /**
     * Tells whether two Enum objects are sameValueAs by comparing their values
     *
     * @param Enum|ValueObject $enum
     * @return bool
     */
    public function equals(Enum|ValueObject $enum): bool
    {
        if (false === Util::classEquals($this, $enum)) {
            return false;
        }

        return $this->toNative() === $enum->toNative();
    }

    /**
     * Returns a native string representation of the Enum value
     */
    public function __toString(): string
    {
        return strval($this->toNative());
    }

    public function jsonSerialize(): array
    {
        return [
            'current'   => $this->getValue(),
            'available' => BaseEnum::getConstants(),
        ];
    }
}
