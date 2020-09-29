<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\FragmentIdentifier;
use Qubus\ValueObjects\Web\NullFragmentIdentifier;

class FragmentIdentifierTest extends TestCase
{
    public function testValidFragmentIdentifier()
    {
        $fragment = new FragmentIdentifier('#id');

        $this->assertInstanceOf('Qubus\ValueObjects\Web\FragmentIdentifier', $fragment);
    }

    public function testNullFragmentIdentifier()
    {
        $fragment = new NullFragmentIdentifier();

        $this->assertInstanceOf('Qubus\ValueObjects\Web\FragmentIdentifier', $fragment);
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidFragmentIdentifier()
    {
        new FragmentIdentifier('invalìd');
    }
}
