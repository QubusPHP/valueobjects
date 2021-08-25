<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Web\Hostname;

class HostnameTest extends TestCase
{
    public function testInvalidHostname()
    {
        new Hostname('inv@lìd');

        $this->expectException(TypeException::class);
    }
}
