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

namespace Qubus\ValueObjects\Geography;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\RealNumber;

use function sprintf;

class Longitude extends RealNumber
{
    /**
     * Returns a new Longitude object.
     *
     * @throws TypeException
     */
    public function __construct($longitude)
    {
        if (! (-180 <= $longitude && $longitude <= 180)) {
            throw new TypeException(
                sprintf('Longitude must be between -180 and 180: %s', $longitude)
            );
        }

        $this->value = $longitude;
    }

    public function longitude(): int|float
    {
        return $this->value;
    }
}
