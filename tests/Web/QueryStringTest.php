<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Web;

use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Web\QueryString;
use Qubus\ValueObjects\Web\NullQueryString;
use Qubus\ValueObjects\Structure\Dictionary;

class QueryStringTest extends TestCase
{
    public function testValidQueryString()
    {
        $query = new QueryString('?foo=bar');

        $this->assertInstanceOf('Qubus\ValueObjects\Web\QueryString', $query);
    }

    public function testEmptyQueryString()
    {
        $query = new NullQueryString();

        $this->assertInstanceOf('Qubus\ValueObjects\Web\QueryString', $query);

        $dictionary = $query->toDictionary();
        $this->assertInstanceOf('Qubus\ValueObjects\Structure\Dictionary', $dictionary);
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidQueryString()
    {
        new QueryString('invalìd');
    }

    public function testToDictionary()
    {
        $query = new QueryString('?foo=bar&array[]=one&array[]=two');
        $dictionary = $query->toDictionary();

        $this->assertInstanceOf('Qubus\ValueObjects\Structure\Dictionary', $dictionary);

        $array = [
            'foo'   => 'bar',
            'array' => [
                'one',
                'two'
            ]
            ];
        $expectedDictionary = Dictionary::fromNative($array);

        $this->assertTrue($expectedDictionary->equals($dictionary));
    }
}
