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

namespace Qubus\ValueObjects\Climate;

use Qubus\ValueObjects\Number\RealNumber;

abstract class Temperature extends RealNumber
{
    abstract public function toCelsius(): Celsius;

    abstract public function toKelvin(): Kelvin;

    abstract public function toFahrenheit(): Fahrenheit;
}
