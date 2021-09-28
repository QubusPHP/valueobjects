<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020 Joshua Parker
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Number;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\IntegerNumber;

use function filter_var;
use function sprintf;

use const FILTER_VALIDATE_INT;

class Natural extends IntegerNumber
{
    /**
     * Returns a Natural object given a PHP native int as parameter.
     *
     * @param int $value
     */
    public function __construct($value)
    {
        $options = [
            'options' => [
                'min_range' => 0,
            ],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must be an integer (>=0).',
                    $value
                )
            );
        }

        parent::__construct($value);
    }
}
