<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\Path;

class PathTest extends TestCase
{
    public function testValidPath()
    {
        $pathString = '/path/to/resource.ext';
        $path = new Path($pathString);
        $this->assertEquals($pathString, $path->toNative());
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidPath()
    {
        new Path('//valid?');
    }
}
