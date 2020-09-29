<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\EmailAddress;

class EmailAddressTest extends TestCase
{
    public function testValidEmailAddress()
    {
        $email1 = new EmailAddress('foo@bar.com');
        $this->assertInstanceOf('Qubus\ValueObjects\Web\EmailAddress', $email1);

        $email2 = new EmailAddress('foo@[120.0.0.1]');
        $this->assertInstanceOf('Qubus\ValueObjects\Web\EmailAddress', $email2);
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidEmailAddress()
    {
        new EmailAddress('invalid');
    }

    public function testGetLocalPart()
    {
        $email = new EmailAddress('foo@bar.baz');
        $localPart = $email->getLocalPart();

        $this->assertEquals('foo', $localPart->toNative());
    }

    public function testGetDomainPart()
    {
        $email = new EmailAddress('foo@bar.com');
        $domainPart = $email->getDomainPart();

        $this->assertEquals('bar.com', $domainPart->toNative());
        $this->assertInstanceOf('Qubus\ValueObjects\Web\Domain', $domainPart);
    }
}
