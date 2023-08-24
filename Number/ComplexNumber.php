<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020
 * @author     Joshua Parker <joshua@joshuaparker.dev>
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Number;

use BadMethodCallException;
use Qubus\Exception\Data\TypeException;
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

class ComplexNumber implements ValueObject
{
    /**
     * Returns a new ComplexNumber object from native PHP arguments
     *
     * @param  float                        $real RealNumber part of the complex number
     * @param  float                        $im   Imaginary part of the complex number
     * @return ComplexNumber|ValueObject
     * @throws BadMethodCallException
     */
    public static function fromNative(): ComplexNumber|ValueObject
    {
        $args = func_get_args();

        if (2 !== count($args)) {
            throw new BadMethodCallException('You must provide 2 arguments: 1) real part, 2) imaginary part');
        }

        $real = RealNumber::fromNative($args[0]);
        $im = RealNumber::fromNative($args[1]);
        return new static($real, $im);
    }

    /**
     * Returns a ComplexNumber given polar coordinates
     *
     * @param RealNumber $modulus
     * @param RealNumber $argument
     * @return ComplexNumber
     * @throws TypeException
     */
    public static function fromPolar(RealNumber $modulus, RealNumber $argument): ComplexNumber
    {
        $realValue = $modulus->toNative() * cos($argument->toNative());
        $imValue = $modulus->toNative() * sin($argument->toNative());
        $real = new RealNumber($realValue);
        $im = new RealNumber($imValue);
        return new static($real, $im);
    }

    /**
     * Returns a ComplexNumber object give its real and imaginary parts as parameters
     */
    public function __construct(
        protected RealNumber $real,
        protected RealNumber $im,
    ) {
    }

    public function equals(ComplexNumber|ValueObject $complex): bool
    {
        if (false === Util::classEquals($this, $complex)) {
            return false;
        }

        return $this->getRealNumber()->equals($complex->getRealNumber()) &&
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
            $this->getRealNumber()->toNative(),
            $this->getIm()->toNative(),
        ];
    }

    /**
     * Returns the real part of the complex number.
     */
    public function getRealNumber(): RealNumber
    {
        return clone $this->real;
    }

    /**
     * Returns the imaginary part of the complex number.
     */
    public function getIm(): RealNumber
    {
        return clone $this->im;
    }

    /**
     * Returns the modulus (or absolute value or magnitude) of the ComplexNumber number.
     * @throws TypeException
     */
    public function getModulus(): RealNumber
    {
        $real = $this->getRealNumber()->toNative();
        $im = $this->getIm()->toNative();
        $mod = sqrt(pow($real, 2) + pow($im, 2));

        return new RealNumber($mod);
    }

    /**
     * Returns the argument (or phase) of the ComplexNumber number.
     * @throws TypeException
     */
    public function getArgument(): RealNumber
    {
        $real = $this->getRealNumber()->toNative();
        $im = $this->getIm()->toNative();
        $arg = atan2($im, $real);

        return new RealNumber($arg);
    }

    /**
     * Returns a native string version of the ComplexNumber object in format "${real} +|- ${complex}i"
     */
    public function __toString(): string
    {
        $format = '%g %+gi';
        $real = $this->getRealNumber()->toNative();
        $im = $this->getIm()->toNative();
        $string = sprintf($format, $real, $im);

        return preg_replace('/(\+|-)/', '$1 ', $string);
    }
}
