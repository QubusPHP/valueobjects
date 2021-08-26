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

namespace Qubus\ValueObjects\Climate;

use Qubus\ValueObjects\Climate\Celsius;
use Qubus\ValueObjects\Climate\Fahrenheit;
use Qubus\ValueObjects\Climate\Kelvin;
use Qubus\ValueObjects\Number\Real;

abstract class Temperature extends Real
{
    abstract public function toCelsius(): Celsius;

    abstract public function toKelvin(): Kelvin;

    abstract public function toFahrenheit(): Fahrenheit;
}
