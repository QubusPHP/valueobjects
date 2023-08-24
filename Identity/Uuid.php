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

namespace Qubus\ValueObjects\Identity;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;
use Ramsey\Uuid\Uuid as BaseUuid;
use Ramsey\Uuid\Validator\GenericValidator;

use function func_get_arg;
use function preg_match;
use function sprintf;
use function strval;

class Uuid extends StringLiteral
{
    protected string $value;

    public function __construct(?string $value = null)
    {
        $uuidStr = BaseUuid::uuid4();

        if (null !== $value) {
            $genericPattern = (new GenericValidator())->getPattern();
            $pattern = '/' . $genericPattern . '/';

            if (! preg_match($pattern, $value)) {
                throw new TypeException(
                    sprintf(
                        'Argument "%s" is invalid. UUID must be a string.',
                        $value
                    )
                );
            }

            $uuidStr = $value;
        }

        $this->value = strval($uuidStr);
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
