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

use BadMethodCallException;
use Qubus\ValueObjects\Number\Real;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;

use function atan2;
use function cos;
use function count;
use function func_get_args;
use function pow;
use function preg_replace;
use function sin;
use function sprintf;
use function sqrt;

class Complex implements ValueObject
{
    protected Real $real;

    protected Real $im;

    /**
     * Returns a new Complex object from native PHP arguments
     *
     * @param  float                        $real Real part of the complex number
     * @param  float                        $im   Imaginary part of the complex number
     * @return Complex|ValueObject
     * @throws BadMethodCallException
     */
    public static function fromNative(): ValueObject
    {
        $args = func_get_args();

        if (2 !== count($args)) {
            throw new BadMethodCallException('You must provide 2 arguments: 1) real part, 2) imaginary part');
        }

        $real = Real::fromNative($args[0]);
        $im = Real::fromNative($args[1]);
        return new static($real, $im);
    }

    /**
     * Returns a Complex given polar coordinates
     *
     * @return Complex
     */
    public static function fromPolar(Real $modulus, Real $argument)
    {
        $realValue = $modulus->toNative() * cos($argument->toNative());
        $imValue = $modulus->toNative() * sin($argument->toNative());
        $real = new Real($realValue);
        $im = new Real($imValue);
        return new static($real, $im);
    }

    /**
     * Returns a Complex object give its real and imaginary parts as parameters
     */
    public function __construct(Real $real, Real $im)
    {
        $this->real = $real;
        $this->im = $im;
    }

    public function equals(ValueObject $complex): bool
    {
        if (false === Util::classEquals($this, $complex)) {
            return false;
        }

        return $this->getReal()->equals($complex->getReal()) &&
        $this->getIm()->equals($complex->getIm());
    }

    /**
     * Returns the native value of the real and imaginary parts as an array
     *
     * @return array
     */
    public function toNative(): array
    {
        return [
            $this->getReal()->toNative(),
            $this->getIm()->toNative(),
        ];
    }

    /**
     * Returns the real part of the complex number
     */
    public function getReal(): Real
    {
        return clone $this->real;
    }

    /**
     * Returns the imaginary part of the complex number
     */
    public function getIm(): Real
    {
        return clone $this->im;
    }

    /**
     * Returns the modulus (or absolute value or magnitude) of the Complex number
     */
    public function getModulus(): Real
    {
        $real = $this->getReal()->toNative();
        $im = $this->getIm()->toNative();
        $mod = sqrt(pow($real, 2) + pow($im, 2));

        return new Real($mod);
    }

    /**
     * Returns the argument (or phase) of the Complex number
     */
    public function getArgument(): Real
    {
        $real = $this->getReal()->toNative();
        $im = $this->getIm()->toNative();
        $arg = atan2($im, $real);

        return new Real($arg);
    }

    /**
     * Returns a native string version of the Complex object in format "${real} +|- ${complex}i"
     */
    public function __toString(): string
    {
        $format = '%g %+gi';
        $real = $this->getReal()->toNative();
        $im = $this->getIm()->toNative();
        $string = sprintf($format, $real, $im);

        return preg_replace('/(\+|-)/', '$1 ', $string);
    }
}
