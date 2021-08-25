<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Person;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Person\Gender;
use Qubus\ValueObjects\ValueObject;

class GenderTest extends TestCase
{
    public function testToNative()
    {
        $gender = Gender::FEMALE();
        Assert::assertEquals(Gender::FEMALE, $gender->toNative());
    }

    public function testSameValueAs()
    {
        $male1 = Gender::MALE();
        $male2 = Gender::MALE();
        $other = Gender::OTHER();

        Assert::assertTrue($male1->equals($male2));
        Assert::assertTrue($male2->equals($male1));
        Assert::assertFalse($male1->equals($other));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($male1->equals($mock));
    }

    public function testToString()
    {
        $sex = Gender::FEMALE();
        Assert::assertEquals('female', $sex->__toString());
    }
}
