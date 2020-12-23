<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Identity;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Identity\Uuid;
use Qubus\ValueObjects\ValueObject;

class UuidTest extends TestCase
{
    public function testGenerateAsString()
    {
        $uuidString = Uuid::generateAsString();

        $this->assertRegexp('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $uuidString);
    }

    public function testFromNative()
    {
        $uuid1 = new Uuid();
        $uuid2 = Uuid::fromNative($uuid1->toNative());

        $this->assertTrue($uuid1->equals($uuid2));
    }

    public function testSameValueAs()
    {
        $uuid1 = new Uuid();
        $uuid2 = clone $uuid1;
        $uuid3 = new Uuid();

        $this->assertTrue($uuid1->equals($uuid2));
        $this->assertFalse($uuid1->equals($uuid3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        $this->assertFalse($uuid1->equals($mock));
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalid()
    {
        new Uuid('invalid');
    }
}
