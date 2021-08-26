<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Number;

use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Number\Natural;

class NaturalTest extends TestCase
{
    public function testInvalidNativeArgument()
    {
        new Natural(-2);

        $this->expectException(TypeException::class);
    }
}
