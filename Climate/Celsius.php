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

use Qubus\ValueObjects\Climate\Fahrenheit;
use Qubus\ValueObjects\Climate\Kelvin;
use Qubus\ValueObjects\Climate\Temperature;

class Celsius extends Temperature
{
    public function toCelsius(): Celsius
    {
        return new static($this->value);
    }

    public function toKelvin(): Kelvin
    {
        return new Kelvin($this->value + 273.15);
    }

    public function toFahrenheit(): Fahrenheit
    {
        return new Fahrenheit($this->value * 1.8 + 32);
    }
}
