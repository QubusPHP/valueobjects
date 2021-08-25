<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Geography;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Geography\CountryCode;
use Qubus\ValueObjects\Geography\CountryCodeName;
use Qubus\ValueObjects\StringLiteral\StringLiteral;

class CountryCodeNameTest extends TestCase
{
    public function testGetName()
    {
        $code = CountryCode::IT();
        $name = CountryCodeName::getName($code);
        $expectedString = new StringLiteral('Italy');

        Assert::assertTrue($name->equals($expectedString));
    }
}
