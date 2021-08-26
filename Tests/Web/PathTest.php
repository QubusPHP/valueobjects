<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Web\Path;

class PathTest extends TestCase
{
    public function testValidPath()
    {
        $pathString = '/path/to/resource.ext';
        $path = new Path($pathString);
        Assert::assertEquals($pathString, $path->toNative());
    }

    public function testInvalidPath()
    {
        new Path('//valid?');

        $this->expectException(TypeException::class);
    }
}
