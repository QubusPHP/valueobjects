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

namespace Qubus\ValueObjects\Number;

use Qubus\Exception\Data\TypeException;

use function filter_var;
use function sprintf;

use const FILTER_VALIDATE_INT;

class Natural extends IntegerNumber
{
    /**
     * Returns a Natural object given a PHP native int as parameter.
     *
     * @param int $value
     * @throws TypeException
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
