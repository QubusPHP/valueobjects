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

namespace Qubus\ValueObjects\Web;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\Natural;
use Qubus\ValueObjects\Web\PortNumber;

use function filter_var;
use function sprintf;

use const FILTER_VALIDATE_INT;

class UrlPortNumber extends Natural implements PortNumber
{
    /**
     * Returns a PortNumber object.
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => [
                'min_range' => 0,
                'max_range' => 65535,
            ],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter an integer (>=0, <=65535).',
                    $value
                )
            );
        }

        parent::__construct($value);
    }
}
