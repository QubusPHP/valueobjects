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

namespace Qubus\ValueObjects\Geography;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\RealNumber;

class Latitude extends RealNumber
{
    /**
     * Returns a new Latitude object.
     *
     * @throws TypeException
     */
    public function __construct(float $latitude)
    {
        if (!(-90 <= $latitude && $latitude <= 90)) {
            throw new TypeException(
                sprintf('Latitude must be between -90 and 90: %s', $latitude)
            );
        }


        $this->value = $latitude;
    }

    public function latitude(): float
    {
        return $this->value;
    }
}
