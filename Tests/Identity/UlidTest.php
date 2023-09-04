<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Identity;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Identity\Ulid;
use Qubus\ValueObjects\ValueObject;

class UlidTest extends TestCase
{
    public function testGenerateAsString()
    {
        $ulidString = Ulid::generateAsString();

        $this->assertMatchesRegularExpression(
            '/[0-9][A-Z]/',
            $ulidString
        );
    }

    public function testFromNative()
    {
        $ulid1 = new Ulid();
        $ulid2 = Ulid::fromNative($ulid1->toNative());

        Assert::assertTrue($ulid1->equals($ulid2));
    }

    public function testSameValueAs()
    {
        $ulid1 = new Ulid();
        $ulid2 = clone $ulid1;
        $ulid3 = new Ulid();

        Assert::assertTrue($ulid1->equals($ulid2));
        Assert::assertFalse($ulid1->equals($ulid3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($ulid1->equals($mock));
    }

    public function testInvalid()
    {
        $this->expectException(TypeException::class);

        new Ulid('invalid');
    }
}
