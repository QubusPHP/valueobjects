<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Person;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Person\Gender;
use Qubus\ValueObjects\ValueObject;

class GenderTest extends TestCase
{
    public function testToNative()
    {
        $gender = Gender::FEMALE();
        $this->assertEquals(Gender::FEMALE, $gender->toNative());
    }

    public function testSameValueAs()
    {
        $male1 = Gender::MALE();
        $male2 = Gender::MALE();
        $other = Gender::OTHER();

        $this->assertTrue($male1->equals($male2));
        $this->assertTrue($male2->equals($male1));
        $this->assertFalse($male1->equals($other));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        $this->assertFalse($male1->equals($mock));
    }

    public function testToString()
    {
        $sex = Gender::FEMALE();
        $this->assertEquals('female', $sex->__toString());
    }
}
