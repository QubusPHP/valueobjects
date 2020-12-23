<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\FragmentIdentifier;
use Qubus\ValueObjects\Web\NullFragmentIdentifier;
use Qubus\ValueObjects\Web\UrlFragmentIdentifier;

class FragmentIdentifierTest extends TestCase
{
    public function testValidFragmentIdentifier()
    {
        $fragment = new UrlFragmentIdentifier('#id');

        $this->assertInstanceOf(FragmentIdentifier::class, $fragment);
    }

    public function testNullFragmentIdentifier()
    {
        $fragment = new NullFragmentIdentifier();

        $this->assertInstanceOf(FragmentIdentifier::class, $fragment);
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidFragmentIdentifier()
    {
        new UrlFragmentIdentifier('invalìd');
    }
}
