<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Geography;

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

        $this->assertTrue($name->equals($expectedString));
    }
}
