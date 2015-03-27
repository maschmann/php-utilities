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

use Asm\Data\Data;

/**
 * Class DataTest
 *
 * @package Asm\Tests\Data
 * @author marc aschmann <maschmann@gmail.com>
 * @uses Asm\Data\Data
 */
class DataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Data
     */
    public function testConstruct()
    {
        $data = new Data();
        $this->assertInstanceOf('\Asm\Data\Data', $data);

        return $data;
    }

    /**
     * test basic set()
     *
     * @depends testConstruct
     * @covers  \Asm\Data\Data::set
     * @covers  \Asm\Data\Data::get
     * @param  Data $data
     * @return Data
     */
    public function testSet(Data $data)
    {
        // test setters

        // test initial setting of value
        $data->set('test_key_1', 'test_value');
        $this->assertEquals('test_value', $data->get('test_key_1'), 'ist value key1 equal to value');

        // test overwrite
        $data->set('test_key_1', 'test_value_blah');
        $this->assertEquals('test_value_blah', $data->get('test_key_1'), 'can key be overwritten');

        $data->set('test_key_1', 'test_key_2', 'test_value3');
        $this->assertEquals('test_value3', $data->get('test_key_1', 'test_key_2'), 'multidim key get');

        // test initial setting of value
        $data->set('test_key_4', ['test_key_3' => 'testValue4']);
        $data->set('test_key_5', ['test_key_4' => 'testValue5']);

        $this->assertEquals('testValue4', $data->get('test_key_4', 'test_key_3'), 'merge arrays on set');
        $this->assertEquals('testValue5', $data->get('test_key_5', 'test_key_4'), 'merge arrays on set');

        return $data;
    }

    /**
     * @depends testSet
     * @expectedException InvalidArgumentException
     * @param Data $data
     */
    public function testSetException(Data $data)
    {
        $data->set();
        $data->set('blah');
    }

    /**
     * test basic get
     *
     * @depends testSet
     * @covers  \Asm\Data\Data::get
     * @covers  \Asm\Data\Data::searchArray
     * @param  Data $data
     * @return Data
     */
    public function testGet(Data $data)
    {
        // single value get
        $data->set('testKey1', 'test_value');
        $this->assertEquals('test_value', $data->get('testKey1'));

        $data->set(
            'testKey2',
            [
                'test'     => 'test_value',
                'sub_test' => [
                    'subsubtest' => 'subvalue',
                ]
            ]
        );

        // single dimension array getter
        $mixResult = $data->get('testKey2');
        $this->assertTrue(is_array($mixResult));
        $this->assertArrayHasKey('test', $mixResult);

        // multi dimension array single value getter
        $mixResult = $data->get('testKey2', 'test');
        $this->assertEquals('test_value', $mixResult);

        // multi dimension array single value getter
        $mixResult = $data->get('testKey2', 'sub_test', 'subsubtest');

        $this->assertEquals('subvalue', $mixResult);

        // non existent keys
        $this->assertFalse($data->get('nothing'));
        $this->assertFalse($data->get('testKey2', 'nothing'));
        $this->assertFalse($data->get('testKey2', 'sub_test', 'nothing'));
        $this->assertTrue(is_array($data->get('testKey2', 'sub_test', '')));

        return $data;
    }

    /**
     * @depends testSet
     * @covers  \Asm\Data\Data::setByArray
     * @param  Data $data
     * @return Data
     */
    public function testSetByArray(Data $data)
    {
        $data->setByArray(
            [
                'testKey3' => 'test_value_3',
                'testKey4' => 'test_value_4',
                'testKey5' => ['subKey1' => 'sub_val_1'],
                'testKey6' => new \stdClass(),
            ]
        );

        $this->assertEquals('test_value_3', $data->get('testKey3'));
        $this->assertEquals('test_value_4', $data->get('testKey4'));
        $this->assertArrayHasKey('subKey1', $data->get('testKey5'));
        $this->assertInstanceOf('stdClass', $data->get('testKey6'));

        return $data;
    }

    /**
     * @depends testConstruct
     * @expectedException InvalidArgumentException
     * @param Data $data
     */
    public function testSetByArrayException(Data $data)
    {
        $data->setByArray([]);
    }

    /**
     * @depends testConstruct
     * @covers  \Asm\Data\Data::setByObject
     * @param  Data $data
     * @return Data
     */
    public function testSetByObject(Data $data)
    {
        $objParam                = new \stdClass();
        $objParam->testProperty1 = 'test_property_value_1';
        $objParam->testProperty2 = 'test_property_value_2';
        $objParam->testProperty3 = ['subkeyPropertyTest' => 'property_value'];
        $objParam->testProperty4 = new \stdClass();

        $data->setByObject($objParam);

        $this->assertEquals('test_property_value_1', $data->get('testProperty1'));
        $this->assertEquals('test_property_value_2', $data->get('testProperty2'));
        $this->assertArrayHasKey('subkeyPropertyTest', $data->get('testProperty3'));
        $this->assertInstanceOf('stdClass', $data->get('testProperty4'));

        $fromData = new Data();
        $fromData->setByObject($data);

        $this->assertEquals('test_property_value_1', $fromData->get('testProperty1'));
        $this->assertEquals('test_property_value_2', $fromData->get('testProperty2'));
        $this->assertArrayHasKey('subkeyPropertyTest', $fromData->get('testProperty3'));
        $this->assertInstanceOf('stdClass', $fromData->get('testProperty4'));

        return $data;
    }

    /**
     * @depends testConstruct
     * @expectedException InvalidArgumentException
     * @param Data $data
     */
    public function testSetByObjectException(Data $data)
    {
        $data->setByObject(null);
    }

    /**
     * @depends testConstruct
     * @covers  \Asm\Data\Data::setByJson
     * @param  Data $data
     * @return Data
     */
    public function testSetByJson(Data $data)
    {
        $data->setByJson(
            json_encode(
                [
                    'testKey3' => 'test_value_3',
                    'testKey4' => 'test_value_4',
                    'testKey5' => ['subKey1' => 'sub_val_1'],
                ]
            )
        );

        $this->assertEquals('test_value_3', $data->get('testKey3'));
        $this->assertEquals('test_value_4', $data->get('testKey4'));
        $this->assertArrayHasKey('subKey1', $data->get('testKey5'));

        return $data;
    }

    /**
     * @depends testSetByArray
     * @covers  \Asm\Data\Data::getKeys
     * @param  Data $data
     */
    public function testGetKeys(Data $data)
    {
        $temp = $data->getKeys();
        $this->assertNotEmpty($temp, "empty array");
        $this->assertNotEmpty($temp[0]);
    }

    /**
     * @depends testSetByArray
     * @covers  \Asm\Data\Data::remove
     * @param  Data $data
     */
    public function testRemove(Data $data)
    {
        $data->set('removal_test', 'xyz');
        $this->assertEquals('xyz', $data->get('removal_test'));
        $data->remove('removal_test');
        $this->assertFalse($data->get('removal_test'));
    }

    /**
     * @depends testSetByArray
     * @covers  \Asm\Data\Data::toArray
     * @param  Data $data
     */
    public function testToArray(Data $data)
    {
        $temp = $data->toArray();
        $this->assertArrayHasKey('testKey5', $temp);
    }

    /**
     * @depends testSetByArray
     * @covers  \Asm\Data\Data::toJson
     * @param  Data $data
     */
    public function testToJson(Data $data)
    {
        $temp = json_decode($data->toJson());

        $this->assertNotFalse($temp);
        $this->assertNotEmpty($temp->testKey5);
    }

    /**
     * @depends testSetByArray
     * @covers  \Asm\Data\Data::count
     * @param  Data $data
     */
    public function testCount(Data $data)
    {
        $temp = $data->toArray();
        $this->assertEquals(count($temp), $data->count());
    }

    /**
     * @depends testSetByArray
     * @covers  \Asm\Data\Data::findInArray
     * @covers  \Asm\Data\Data::searchArray
     * @param  Data $data
     */
    public function testFindInArray(Data $data)
    {
        $temp = $data->toArray();

        $this->assertNotFalse(Data::findInArray($temp, 'testKey5'));
        $this->assertNotFalse(Data::findInArray($temp, 'testProperty3', 'subkeyPropertyTest'));
        $this->assertFalse(Data::findInArray($temp, 'testKey35', false));
    }

    /**
     * @covers \Asm\Data\Data::normalize
     */
    public function testNormalize()
    {
        $key = Data::normalize('this_is_my_key');
        $this->assertEquals('thisIsMyKey', $key);
    }

    /**
     * @depends testSetByArray
     * @covers  \Asm\Data\Data::setByArray
     * @covers  \Asm\Data\Data::clear
     * @covers  \Asm\Data\Data::toArray
     * @param Data $data
     */
    public function testClear(Data $data)
    {
        $data->clear();
        $this->assertArrayNotHasKey('testKey3', $data->toArray());
    }
}
