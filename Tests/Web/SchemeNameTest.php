<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Web\SchemeName;

class SchemeNameTest extends TestCase
{
    public function testValidSchemeName()
    {
        $scheme = new SchemeName('git+ssh');
        Assert::assertInstanceOf(SchemeName::class, $scheme);
    }

    public function testInvalidSchemeName()
    {
        new SchemeName('ht*tp');

        $this->expectException(TypeException::class);
    }
}
