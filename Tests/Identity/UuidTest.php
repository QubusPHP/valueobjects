<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Identity;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Identity\Uuid;
use Qubus\ValueObjects\ValueObject;

class UuidTest extends TestCase
{
    public function testGenerateAsString()
    {
        $uuidString = Uuid::generateAsString();

        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/',
            $uuidString
        );
    }

    public function testFromNative()
    {
        $uuid1 = new Uuid();
        $uuid2 = Uuid::fromNative($uuid1->toNative());

        Assert::assertTrue($uuid1->equals($uuid2));
    }

    public function testSameValueAs()
    {
        $uuid1 = new Uuid();
        $uuid2 = clone $uuid1;
        $uuid3 = new Uuid();

        Assert::assertTrue($uuid1->equals($uuid2));
        Assert::assertFalse($uuid1->equals($uuid3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($uuid1->equals($mock));
    }

    public function testInvalid()
    {
        $this->expectException(TypeException::class);

        new Uuid('invalid');
    }
}
