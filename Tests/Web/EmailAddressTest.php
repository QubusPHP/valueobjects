<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Web\Domain;
use Qubus\ValueObjects\Web\EmailAddress;

class EmailAddressTest extends TestCase
{
    public function testValidEmailAddress()
    {
        $email1 = new EmailAddress('foo@bar.com');
        Assert::assertInstanceOf(EmailAddress::class, $email1);

        $email2 = new EmailAddress('foo@[120.0.0.1]');
        Assert::assertInstanceOf(EmailAddress::class, $email2);
    }

    public function testInvalidEmailAddress()
    {
        $this->expectException(TypeException::class);

        new EmailAddress('invalid');
    }

    public function testGetLocalPart()
    {
        $email = new EmailAddress('foo@bar.baz');
        $localPart = $email->getLocalPart();

        Assert::assertEquals('foo', $localPart->toNative());
    }

    public function testGetDomainPart()
    {
        $email = new EmailAddress('foo@bar.com');
        $domainPart = $email->getDomainPart();

        Assert::assertEquals('bar.com', $domainPart->toNative());
        Assert::assertInstanceOf(Domain::class, $domainPart);
    }
}
