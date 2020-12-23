<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\Hostname;

class HostnameTest extends TestCase
{
    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidHostname()
    {
        new Hostname('inv@lìd');
    }
}
