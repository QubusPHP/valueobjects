<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Web\FragmentIdentifier;
use Qubus\ValueObjects\Web\NullFragmentIdentifier;
use Qubus\ValueObjects\Web\UrlFragmentIdentifier;

class FragmentIdentifierTest extends TestCase
{
    public function testValidFragmentIdentifier()
    {
        $fragment = new UrlFragmentIdentifier('#id');

        Assert::assertInstanceOf(FragmentIdentifier::class, $fragment);
    }

    public function testNullFragmentIdentifier()
    {
        $fragment = new NullFragmentIdentifier();

        Assert::assertInstanceOf(FragmentIdentifier::class, $fragment);
    }

    public function testInvalidFragmentIdentifier()
    {
        new UrlFragmentIdentifier('invalìd');

        $this->expectException(TypeException::class);
    }
}
