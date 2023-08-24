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

namespace Qubus\ValueObjects\DateTime;

use Carbon\CarbonImmutable;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\Natural;
use Qubus\ValueObjects\ValueObject;

use function filter_var;
use function func_get_arg;
use function intval;
use function sprintf;

use const FILTER_VALIDATE_INT;

class Hour extends Natural
{
    public const MIN_HOUR = 0;
    public const MAX_HOUR = 23;

    /**
     * Returns a new Hour object.
     *
     * @throws TypeException
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => ['min_range' => self::MIN_HOUR, 'max_range' => self::MAX_HOUR],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter an integer between 0 and 23.',
                    $value
                )
            );
        }

        parent::__construct($value);
    }

    /**
     * Returns a new Hour from native int value.
     *
     * @param ...int $value
     * @return Hour|ValueObject
     * @throws TypeException
     */
    public static function fromNative(): Hour|ValueObject
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns the current hour.
     * @throws TypeException
     */
    public static function now(): Hour
    {
        $now = new CarbonImmutable('now');
        $hour = intval($now->format('G'));

        return new static($hour);
    }
}
