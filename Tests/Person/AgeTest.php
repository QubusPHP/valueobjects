<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Person;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Person\Age;
use Qubus\ValueObjects\ValueObject;

class AgeTest extends TestCase
{
    public function testToNative()
    {
        $age = new Age(25);
        $this->assertEquals(25, $age->toNative());
    }

    public function testSameValueAs()
    {
        $age1 = new Age(33);
        $age2 = new Age(33);
        $age3 = new Age(66);

        $this->assertTrue($age1->equals($age2));
        $this->assertTrue($age2->equals($age1));
        $this->assertFalse($age1->equals($age3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        $this->assertFalse($age1->equals($mock));
    }

    public function testToString()
    {
        $age = new Age(54);
        $this->assertEquals('54', $age->__toString());
    }
}
