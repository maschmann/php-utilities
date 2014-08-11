<?php
/**
 * @namespace Asm\Tests\Data
 */
namespace Asm\Tests\Data;

use Asm\Test\LibraryTestCase;
use Asm\Data\Data;

/**
 * Class DataTest
 *
 * @package Asm\Tests\Data
 * @author marc aschmann <maschmann@gmail.com>
 * @uses Asm\Test\LibraryTestCase
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
     * test basic setKey()
     *
     * @depends testConstruct
     * @covers  \Asm\Data\Data::setKey
     * @covers  \Asm\Data\Data::set
     * @covers  \Asm\Data\Data::getKey
     * @param  Data $data
     * @return Data
     */
    public function testSetKey(Data $data)
    {
        // test setters

        // test initial setting of value
        $data->setKey('test_key_1', 'test_value');
        $this->assertEquals('test_value', $data->getKey('test_key_1'), 'ist value key1 equal to value');

        // test overwrite
        $data->setKey('test_key_1', 'test_value_blah');
        $this->assertEquals('test_value_blah', $data->getKey('test_key_1'), 'can key be overwritten');

        $data->setKey('test_key_1', 'test_key_2', 'test_value3');
        $this->assertEquals('test_value3', $data->getKey('test_key_1', 'test_key_2'), 'multidim key get');

        // test initial setting of value
        $data->setKey('test_key_4', array('test_key_3' => 'testValue4'));
        $data->setKey('test_key_5', array('test_key_4' => 'testValue5'));

        $this->assertEquals('testValue4', $data->getKey('test_key_4', 'test_key_3'), 'merge arrays on set');
        $this->assertEquals('testValue5', $data->getKey('test_key_5', 'test_key_4'), 'merge arrays on set');

        return $data;
    }

    /**
     * @depends testSetKey
     * @expectedException InvalidArgumentException
     * @param Data $data
     */
    public function testSetKeyException(Data $data)
    {
        $data->setKey();
        $data->setKey('blah');
    }

    /**
     * test basic getKey
     *
     * @depends testSetKey
     * @covers  \Asm\Data\Data::getKey
     * @covers  \Asm\Data\Data::__call
     * @param  Data $data
     * @return Data
     */
    public function testGetKey(Data $data)
    {
        // single value get
        $data->setKey('testKey1', 'test_value');
        $this->assertEquals('test_value', $data->getKey('testKey1'));

        $data->setKey(
            'testKey2',
            array(
                'test'     => 'test_value',
                'sub_test' => array(
                    'subsubtest' => 'subvalue',
                )
            )
        );

        // single dimension array getter
        $mixResult = $data->getKey('testKey2');
        $this->assertTrue(is_array($mixResult));
        $this->assertArrayHasKey('test', $mixResult);

        // multi dimension array single value getter
        $mixResult = $data->getKey('testKey2', 'test');
        $this->assertEquals('test_value', $mixResult);

        // multi dimension array single value getter
        $mixResult = $data->getKey('testKey2', 'sub_test', 'subsubtest');

        $this->assertEquals('subvalue', $mixResult);

        // non existent keys
        $this->assertFalse($data->getKey('nothing'));
        $this->assertFalse($data->getKey('testKey2', 'nothing'));
        $this->assertFalse($data->getKey('testKey2', 'sub_test', 'nothing'));
        $this->assertTrue(is_array($data->getKey('testKey2', 'sub_test', '')));

        return $data;
    }

    /**
     * @depends testSetKey
     * @covers  \Asm\Data\Data::setByArray
     * @param  Data $data
     * @return Data
     */
    public function testSetByArray(Data $data)
    {
        $data->setByArray(
            array(
                'testKey3' => 'test_value_3',
                'testKey4' => 'test_value_4',
                'testKey5' => array('subKey1' => 'sub_val_1'),
                'testKey6' => new \stdClass(),
            )
        );

        $this->assertEquals('test_value_3', $data->getKey('testKey3'));
        $this->assertEquals('test_value_4', $data->getKey('testKey4'));
        $this->assertArrayHasKey('subKey1', $data->getKey('testKey5'));
        $this->assertInstanceOf('stdClass', $data->getKey('testKey6'));

        return $data;
    }

    /**
     * @depends testConstruct
     * @covers \Asm\Data\Data::setByObject
     * @param  Data $data
     * @return Data
     */
    public function testSetByObject(Data $data)
    {
        $objParam = new \stdClass();
        $objParam->testProperty1 = 'test_property_value_1';
        $objParam->testProperty2 = 'test_property_value_2';
        $objParam->testProperty3 = array('subkeyPropertyTest' => 'property_value');
        $objParam->testProperty4 = new \stdClass();

        $data->setByObject($objParam);

        $this->assertEquals('test_property_value_1', $data->getKey('testProperty1'));
        $this->assertEquals('test_property_value_2', $data->getKey('testProperty2'));
        $this->assertArrayHasKey('subkeyPropertyTest', $data->getKey('testProperty3'));
        $this->assertInstanceOf('stdClass', $data->getKey('testProperty4'));

        return $data;
    }

    /**
     * @depends testSetByArray
     * @covers \Asm\Data\Data::setByArray
     * @covers \Asm\Data\Data::clear
     * @covers \Asm\Data\Data::toArray
     * @param Data $data
     */
    public function testClear(Data $data)
    {
        $data->clear();
        $this->assertArrayNotHasKey('testKey3', $data->toArray());
    }
}
