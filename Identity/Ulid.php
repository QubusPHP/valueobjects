<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2023
 * @author     Joshua Parker <joshua@joshuaparker.dev>
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Identity;

use DateTimeInterface;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;
use Ramsey\Uuid\Uuid as BaseUuid;

use Tuupola\Base32;

use function func_get_arg;
use function strval;

class Ulid extends StringLiteral
{
    protected string $value;

    public function __construct(?string $value = null)
    {
        $crockford = new Base32([
            'characters' => Base32::CROCKFORD,
            'padding' => false,
            'crockford' => true,
        ]);

        $uuidStr = BaseUuid::uuid7();

        $bytes = str_pad($uuidStr->getBytes(), 20, "\x00", STR_PAD_LEFT);
        $encoded = $crockford->encode($bytes);
        $ulidStr = substr($encoded, 6);

        if (null !== $value) {
            if (!preg_match('/[0-9][A-Z]/', $value)) {
                throw new TypeException(
                    sprintf(
                        'Argument "%s" is invalid. ULID must be a string in the proper format.',
                        $value
                    )
                );
            }

            $ulidStr = $value;
        }

        $this->value = strval($ulidStr);
    }

    /**
     * @throws TypeException
     */
    public static function fromNative(): ValueObject
    {
        $uuidStr = func_get_arg(0);
        return new static($uuidStr);
    }

    /**
     * Generate a new Uuid string.
     */
    public static function generateAsString(): string
    {
        $uuid = new static();
        return $uuid->toNative();
    }

    /**
     * Tells whether two Uuid are equal by comparing their values.
     */
    public function equals(ValueObject $uuid): bool
    {
        if (false === Util::classEquals($this, $uuid)) {
            return false;
        }

        return $this->toNative() === $uuid->toNative();
    }
}
