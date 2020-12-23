<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\SchemeName;

class SchemeNameTest extends TestCase
{
    public function testValidSchemeName()
    {
        $scheme = new SchemeName('git+ssh');
        $this->assertInstanceOf(SchemeName::class, $scheme);
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidSchemeName()
    {
        new SchemeName('ht*tp');
    }
}
