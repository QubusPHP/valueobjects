<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Structure\Dictionary;
use Qubus\ValueObjects\Web\NullQueryString;
use Qubus\ValueObjects\Web\QueryString;
use Qubus\ValueObjects\Web\UrlQueryString;

class QueryStringTest extends TestCase
{
    public function testValidQueryString()
    {
        $query = new UrlQueryString('?foo=bar');

        Assert::assertInstanceOf(QueryString::class, $query);
    }

    public function testEmptyQueryString()
    {
        $query = new NullQueryString();

        Assert::assertInstanceOf(QueryString::class, $query);

        $dictionary = $query->toDictionary();
        Assert::assertInstanceOf(Dictionary::class, $dictionary);
    }

    public function testInvalidQueryString()
    {
        new UrlQueryString('invalìd');

        $this->expectException(TypeException::class);
    }

    public function testToDictionary()
    {
        $query = new UrlQueryString('?foo=bar&array[]=one&array[]=two');
        $dictionary = $query->toDictionary();

        Assert::assertInstanceOf(Dictionary::class, $dictionary);

        $array = [
            'foo'   => 'bar',
            'array' => [
                'one',
                'two',
            ],
        ];
        $expectedDictionary = Dictionary::fromNative($array);

        Assert::assertTrue($expectedDictionary->equals($dictionary));
    }
}
