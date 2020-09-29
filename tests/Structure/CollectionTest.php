<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Test\Structure;

use SplFixedArray;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\Number\Integer;
use Qubus\ValueObjects\Number\Natural;
use Qubus\ValueObjects\Structure\Collection;
use Qubus\ValueObjects\ValueObjectInterface;
use Qubus\ValueObjects\StringLiteral\StringLiteral;

class CollectionTest extends TestCase
{
    /** @var Collection */
    protected $collection;

    public function setup()
    {
        $array = new SplFixedArray(3);
        $array->offsetSet(0, new StringLiteral('one'));
        $array->offsetSet(1, new StringLiteral('two'));
        $array->offsetSet(2, new Integer(3));

        $this->collection = new Collection($array);
    }

    /** @expectedException \Qubus\Exception\Data\TypeException */
    public function testInvalidArgument()
    {
        $array = SplFixedArray::fromArray(['one', 'two', 'three']);

        new Collection($array);
    }

    public function testFromNative()
    {
        $array = SplFixedArray::fromArray([
            'one',
            'two',
            [1, 2],
        ]);
        $fromNativeCollection = Collection::fromNative($array);

        $innerArray = new Collection(
            SplFixedArray::fromArray([
                new StringLiteral('1'),
                new StringLiteral('2'),
            ])
        );
        $array = SplFixedArray::fromArray([
            new StringLiteral('one'),
            new StringLiteral('two'),
            $innerArray,
        ]);
        $constructedCollection = new Collection($array);

        $this->assertTrue($fromNativeCollection->equals($constructedCollection));
    }

    public function testSameValueAs()
    {
        $array = SplFixedArray::fromArray([
            new StringLiteral('one'),
            new StringLiteral('two'),
            new Integer(3),
        ]);
        $collection2 = new Collection($array);

        $array = SplFixedArray::fromArray([
            'one',
            'two',
            [1, 2],
        ]);
        $collection3 = Collection::fromNative($array);

        $this->assertTrue($this->collection->equals($collection2));
        $this->assertTrue($collection2->equals($this->collection));
        $this->assertFalse($this->collection->equals($collection3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)
            ->getMock();
        $this->assertFalse($this->collection->equals($mock));
    }

    public function testCount()
    {
        $three = new Natural(3);

        $this->assertTrue($this->collection->count()->equals($three));
    }

    public function testContains()
    {
        $one = new StringLiteral('one');
        $ten = new StringLiteral('ten');

        $this->assertTrue($this->collection->contains($one));
        $this->assertFalse($this->collection->contains($ten));
    }

    public function testToArray()
    {
        $array = [
            new StringLiteral('one'),
            new StringLiteral('two'),
            new Integer(3),
        ];

        $this->assertEquals($array, $this->collection->toArray());
    }

    public function testToString()
    {
        $this->assertEquals('Qubus\ValueObjects\Structure\Collection(3)', $this->collection->__toString());
    }
}
