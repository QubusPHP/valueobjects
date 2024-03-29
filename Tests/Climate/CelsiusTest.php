<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Climate;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Climate\Celsius;

use function setlocale;

use const LC_ALL;

class CelsiusTest extends TestCase
{
    public function setUp(): void
    {
        // When tests run in a different locale, this might affect the decimal-point character and thus the validation
        // of floats. This makes sure the tests run in a locale that the tests are known to be working in.
        setlocale(LC_ALL, "en_US.UTF-8");
    }

    public function temperatureProvider()
    {
        return [[new Celsius(10)]];
    }

    /**
     * @dataProvider temperatureProvider
     */
    public function testToCelsius(Celsius $temperature)
    {
        Assert::assertEquals(10, $temperature->toCelsius()->toNative());
    }

    /**
     * @dataProvider temperatureProvider
     */
    public function testToKelvin(Celsius $temperature)
    {
        Assert::assertEquals(10 + 273.15, $temperature->toKelvin()->toNative());
    }

    /**
     * @dataProvider temperatureProvider
     */
    public function testToFahrenheit(Celsius $temperature)
    {
        Assert::assertEquals(10 * 1.8 + 32, $temperature->toFahrenheit()->toNative());
    }

    /**
     * @dataProvider temperatureProvider
     */
    public function testDifferentLocaleWithDifferentDecimalCharacter(Celsius $temperature)
    {
        setlocale(LC_ALL, "de_DE.UTF-8");

        $this->testToCelsius($temperature);
        $this->testToKelvin($temperature);
        $this->testToFahrenheit($temperature);
    }
}
