<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Identity;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Identity\UUID;
use Qubus\ValueObjects\ValueObjectInterface;

class UUIDTest extends TestCase
{
    public function testGenerateAsString()
    {
        $uuidString = UUID::generateAsString();

        $this->assertRegexp('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $uuidString);
    }

    public function testFromNative()
    {
        $uuid1 = new UUID();
        $uuid2 = UUID::fromNative($uuid1->toNative());

        $this->assertTrue($uuid1->equals($uuid2));
    }

    public function testSameValueAs()
    {
        $uuid1 = new UUID();
        $uuid2 = clone $uuid1;
        $uuid3 = new UUID();

        $this->assertTrue($uuid1->equals($uuid2));
        $this->assertFalse($uuid1->equals($uuid3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)
            ->getMock();
        $this->assertFalse($uuid1->equals($mock));
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalid()
    {
        new UUID('invalid');
    }
}
