<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Enum;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Enum\Enum;

class EnumTest extends TestCase
{
    public function testSameValueAs()
    {
        /** @var Enum|MockObject $stub1 */
        $stub1 = $this->getMockBuilder(Enum::class)
            ->setConstructorArgs([])
            ->setMockClassName('')
            ->disableOriginalConstructor()->getMock();
        /** @var Enum|MockObject $stub2 */
        $stub2 = $this->getMockBuilder(Enum::class)
            ->setConstructorArgs([])
            ->setMockClassName('')
            ->disableOriginalConstructor()->getMock();
        $stub1->expects($this->any())
            ->method('equals')
            ->will($this->returnValue(true));

        $this->assertTrue($stub1->equals($stub2));
    }

    public function testToString()
    {
        /** @var Enum $stub */
        $stub = $this->getMockBuilder(Enum::class)
            ->setConstructorArgs([])
            ->setMockClassName('')
            ->disableOriginalConstructor()->getMock();
        $this->assertEquals('', $stub->__toString());
    }
}
