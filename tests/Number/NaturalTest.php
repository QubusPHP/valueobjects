<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Number;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Number\Natural;

class NaturalTest extends TestCase
{
    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidNativeArgument()
    {
        new Natural(-2);
    }
}
