<?php
/*
 * This file is part of the php-utilities package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Asm\Tests\Data;

use Asm\Data\DataCollection;

/**
 * tests for cache factory
 *
 * @package Asm\Tests\Data
 * @author Marc Aschmann <maschmann@gmail.com>
 * @uses Asm\Data\DataCollection
 */
class DataCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Asm\Data\DataCollection::__construct
     * @covers \Asm\Data\DataCollection::getItem
     * @return DataCollection
     */
    public function testConstruct()
    {
        $item = new \stdClass();
        $item->name = 'number_one';

        $collection = new DataCollection([$item]);
        $this->assertInstanceOf('\Asm\Data\DataCollection', $collection);

        $this->assertEquals('number_one', $collection->getItem(0)->name);

        return $collection;
    }

    /**
     * @depends testConstruct
     * @covers \Asm\Data\DataCollection::addItem
     * @covers \Asm\Data\DataCollection::getItem
     * @param DataCollection $collection
     * @return DataCollection
     */
    public function testAddAndGetItem(DataCollection $collection)
    {
        $item = new \stdClass();
        $item->name = 'number_two';
        $collection->addItem($item);
        $this->assertEquals('number_two', $collection->getItem(1)->name);

        $item = new \stdClass();
        $item->name = 'number_three';
        $collection->addItem($item);
        $this->assertEquals('number_three', $collection->getItem(2)->name);

        $item = new \stdClass();
        $item->name = 'number_ten';
        $collection->addItem($item, 10);
        $this->assertEquals('number_ten', $collection->getItem(10)->name);

        return $collection;
    }

    /**
     * @depends testAddAndGetItem
     * @covers \Asm\Data\DataCollection::count
     * @param DataCollection $collection
     * @return DataCollection
     */
    public function testCount(DataCollection $collection)
    {
        $this->assertEquals(4, $collection->count());

        return $collection;
    }

    /**
     * @depends testCount
     * @covers \Asm\Data\DataCollection::next
     * @covers \Asm\Data\DataCollection::key
     * @param DataCollection $collection
     * @return DataCollection
     */
    public function testNextAndKey(DataCollection $collection)
    {
        $this->assertEquals(0, $collection->key());
        $collection->next();
        $this->assertEquals(1, $collection->key());
        $collection->next();
        $this->assertEquals(2, $collection->key());

        return $collection;
    }

    /**
     * @depends testNextAndKey
     * @covers \Asm\Data\DataCollection::current
     * @covers \Asm\Data\DataCollection::valid
     * @param DataCollection $collection
     * @return DataCollection
     */
    public function testCurrentAndValid(DataCollection $collection)
    {
        $this->assertEquals('number_three', $collection->current()->name);
        $this->assertNotFalse($collection->valid());

        return $collection;
    }

    /**
     * @depends testCurrentAndValid
     * @covers \Asm\Data\DataCollection::rewind
     * @param DataCollection $collection
     * @return DataCollection
     */
    public function testRewind(DataCollection $collection)
    {
        $collection->rewind();
        $this->assertEquals(0, $collection->key());

        return $collection;
    }

    /**
     * @depends testRewind
     * @covers \Asm\Data\DataCollection::removeItem
     * @param DataCollection $collection
     * @return DataCollection
     */
    public function testRemoveItem(DataCollection $collection)
    {
        $collection->removeItem(10);
        $this->assertFalse($collection->getItem(10));

        return $collection;
    }
}
