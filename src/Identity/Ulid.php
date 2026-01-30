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

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Ramsey\Uuid\Uuid as BaseUuid;
use Tuupola\Base32;

use function strval;

class Ulid extends StringLiteral
{
    protected string $value;

    /**
     * @throws TypeException
     */
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

        parent::__construct(strval($ulidStr));
    }

    /**
     * Generate a new Uuid string.
     */
    public static function generateAsString(): string
    {
        $uuid = new self();
        return $uuid->toNative();
    }
}
