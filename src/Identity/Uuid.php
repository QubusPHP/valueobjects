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

namespace Qubus\ValueObjects\Identity;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Ramsey\Uuid\Uuid as BaseUuid;
use Ramsey\Uuid\Validator\GenericValidator;

use function func_get_arg;
use function preg_match;
use function sprintf;
use function strval;

class Uuid extends StringLiteral
{
    protected string $value;

    /**
     * @throws TypeException
     */
    public function __construct(?string $value = null)
    {
        $uuidStr = BaseUuid::uuid4();

        if (null !== $value) {
            $genericPattern = new GenericValidator()->getPattern();
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

        parent::__construct(strval($uuidStr));
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
