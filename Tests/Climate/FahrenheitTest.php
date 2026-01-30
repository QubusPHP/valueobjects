<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Climate;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Climate\Fahrenheit;

use function round;
use function setlocale;

use const LC_ALL;

class FahrenheitTest extends TestCase
{
    public function setUp(): void
    {
        // When tests run in a different locale, this might affect the decimal-point character and thus the validation
        // of floats. This makes sure the tests run in a locale that the tests are known to be working in.
        setlocale(LC_ALL, "en_US.UTF-8");
    }

    public static function temperatureProvider(): array
    {
        return [[new Fahrenheit(10)]];
    }

    #[DataProvider('temperatureProvider')]
    public function testToCelsius(Fahrenheit $temperature)
    {
        Assert::assertEquals((10 - 32) / 1.8, $temperature->toCelsius()->toNative());
    }

    #[DataProvider('temperatureProvider')]
    public function testToKelvin(Fahrenheit $temperature)
    {
        Assert::assertEquals(
            round($temperature->toCelsius()->toNative() + 273.15, 8),
            round($temperature->toKelvin()->toNative(), 8)
        );
    }

    #[DataProvider('temperatureProvider')]
    public function testToFahrenheit(Fahrenheit $temperature)
    {
        Assert::assertEquals(10, $temperature->toFahrenheit()->toNative());
    }

    #[DataProvider('temperatureProvider')]
    public function testDifferentLocaleWithDifferentDecimalCharacter(Fahrenheit $temperature)
    {
        setlocale(LC_ALL, "de_DE.UTF-8");

        $this->testToCelsius($temperature);
        $this->testToKelvin($temperature);
        $this->testToFahrenheit($temperature);
    }
}
