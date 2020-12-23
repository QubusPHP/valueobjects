<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Structure\Dictionary;
use Qubus\ValueObjects\Web\NullQueryString;
use Qubus\ValueObjects\Web\QueryString;
use Qubus\ValueObjects\Web\UrlQueryString;

class QueryStringTest extends TestCase
{
    public function testValidQueryString()
    {
        $query = new UrlQueryString('?foo=bar');

        $this->assertInstanceOf(QueryString::class, $query);
    }

    public function testEmptyQueryString()
    {
        $query = new NullQueryString();

        $this->assertInstanceOf(QueryString::class, $query);

        $dictionary = $query->toDictionary();
        $this->assertInstanceOf(Dictionary::class, $dictionary);
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidQueryString()
    {
        new UrlQueryString('invalìd');
    }

    public function testToDictionary()
    {
        $query = new UrlQueryString('?foo=bar&array[]=one&array[]=two');
        $dictionary = $query->toDictionary();

        $this->assertInstanceOf(Dictionary::class, $dictionary);

        $array = [
            'foo'   => 'bar',
            'array' => [
                'one',
                'two',
            ],
        ];
        $expectedDictionary = Dictionary::fromNative($array);

        $this->assertTrue($expectedDictionary->equals($dictionary));
    }
}
