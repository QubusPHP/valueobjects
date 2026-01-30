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

class Second extends Natural
{
    public const int MIN_SECOND = 0;
    public const int MAX_SECOND = 59;

    /**
     * Returns a new Second object.
     * @throws TypeException
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => ['min_range' => self::MIN_SECOND, 'max_range' => self::MAX_SECOND],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter an integer between 0 and 59.',
                    $value
                )
            );
        }

        parent::__construct($value);
    }

    /**
     * Returns a new Second from native int value.
     *
     * @param ...int $value
     * @return Second|ValueObject
     * @throws TypeException
     */
    public static function fromNative(): Second|ValueObject
    {
        $value = func_get_arg(0);

        return new self($value);
    }

    /**
     * Returns the current second.
     * @throws TypeException
     */
    public static function now(): Second
    {
        $now = new CarbonImmutable('now');
        $second = intval($now->format('s'));

        return new self($second);
    }
}
