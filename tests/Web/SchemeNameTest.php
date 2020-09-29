<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\SchemeName;

class SchemeNameTest extends TestCase
{
    public function testValidSchemeName()
    {
        $scheme = new SchemeName('git+ssh');
        $this->assertInstanceOf('Qubus\ValueObjects\Web\SchemeName', $scheme);
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidSchemeName()
    {
        new SchemeName('ht*tp');
    }
}
