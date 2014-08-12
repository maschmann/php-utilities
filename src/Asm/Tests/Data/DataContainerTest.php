<?php
/**
 * @namespace
 */
namespace Asm\Tests\Data;

use Asm\Test\LibraryTestCase;
use Asm\Data\DataContainer;

/**
 * tests for cache factory
 *
 * @package Asm\Tests\Data
 * @author Marc Aschmann <maschmann@gmail.com>
 * @uses Asm\Test\LibraryTestCase
 * @uses Asm\Data\DataContainer
 */
class DataContainerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return DataContainer
     */
    public function testConstruct()
    {
        $dataContainer = new DataContainer();
        $this->assertInstanceOf('\Asm\Data\DataContainer', $dataContainer);

        return $dataContainer;
    }

    /**
     * test basic setKey()
     *
     * @depends testConstruct
     * @covers  \Asm\Data\DataContainer::setKey
     * @covers  \Asm\Data\DataContainer::set
     * @covers  \Asm\Data\DataContainer::getKey
     * @param  DataContainer $dataContainer
     * @return DataContainer
     */
    public function testSetKey(DataContainer $dataContainer)
    {

        // test setters

        // test initial setting of value
        $dataContainer->setKey('test_key_1', 'test_value');
        $this->assertEquals('test_value', $dataContainer->getKey('test_key_1'), 'ist value key1 equal to value');

        // test overwrite
        $dataContainer->setKey('test_key_1', 'test_value_blah');
        $this->assertEquals('test_value_blah', $dataContainer->getKey('test_key_1'), 'can key be overwritten');

        $dataContainer->setKey('test_key_1', 'testKey2', 'test_value3');
        $this->assertEquals('test_value3', $dataContainer->getKey('testKey1', 'test_key_2'), 'multidim key get');

        // test initial setting of value
        $dataContainer->setKey('test_key_1', array('testKey3' => 'testValue4'));
        $dataContainer->setKey('test_key_1', array('testKey4' => 'testValue5'));

        $this->assertEquals('testValue4', $dataContainer->getKey('testKey1', 'test_key_3'), 'merge arrays on set');
        $this->assertEquals('testValue5', $dataContainer->getKey('testKey1', 'test_key_4'), 'merge arrays on set');

        return $dataContainer;
    }

    /**
     * @depends testSetKey
     * @expectedException InvalidArgumentException
     * @param DataContainer $dataContainer
     */
    public function testSetKeyException(DataContainer $dataContainer)
    {
        $dataContainer->setKey();
        $dataContainer->setKey('blah');
    }

    /**
     * test basic _call
     *
     * @depends testConstruct
     * @covers  \Asm\Data\DataContainer::__call
     * @param  DataContainer $dataContainer
     * @return DataContainer
     */
    public function testCallGetSetKey(DataContainer $dataContainer)
    {
        // test initial setting of value
        $dataContainer->setTestKey2('test_value');
        $this->assertEquals('test_value', $dataContainer->getTestKey2());

        // test overwrite
        $dataContainer->setTestKey2('test_value_blah');
        $this->assertEquals('test_value_blah', $dataContainer->getTestKey2());

        return $dataContainer;
    }

    /**
     * @depends testSetKey
     * @expectedException InvalidArgumentException
     * @param DataContainer $dataContainer
     */
    public function testCallGetSetKeyException(DataContainer $dataContainer)
    {
        $dataContainer->newDefaultKey();
    }

    /**
     * test basic getKey
     *
     * @depends testSetKey
     * @covers  \Asm\Data\DataContainer::getKey
     * @covers  \Asm\Data\DataContainer::__call
     * @param  DataContainer $dataContainer
     * @return DataContainer
     */
    public function testGetKey(DataContainer $dataContainer)
    {
        // single value get
        $dataContainer->setTestKey1('test_value');
        $this->assertEquals('test_value', $dataContainer->getTestKey1());

        $dataContainer->setTestKey2(
            array(
                'test'     => 'test_value',
                'sub_test' => array(
                    'subsubtest' => 'subvalue',
                )
            )
        );

        // single dimension array getter
        $mixResult = $dataContainer->getTestKey2();
        $this->assertTrue(is_array($mixResult));
        $this->assertArrayHasKey('test', $mixResult);

        // multi dimension array single value getter
        $mixResult = $dataContainer->getKey('testKey2', 'test');
        $this->assertEquals('test_value', $mixResult);

        // multi dimension array single value getter
        $mixResult = $dataContainer->getKey('testKey2', 'sub_test', 'subsubtest');

        $this->assertEquals('subvalue', $mixResult);

        // non existent keys
        $this->assertFalse($dataContainer->getKey('nothing'));
        $this->assertFalse($dataContainer->getKey('testKey2', 'nothing'));
        $this->assertFalse($dataContainer->getKey('testKey2', 'sub_test', 'nothing'));
        $this->assertTrue(is_array($dataContainer->getKey('testKey2', 'sub_test', '')));

        return $dataContainer;
    }

    /**
     * test add to key functionality
     *
     * @depends testGetKey
     * @covers  \Asm\Data\DataContainer::addToKey
     * @param  DataContainer $dataContainer
     * @return DataContainer
     */
    public function testAddToKey(DataContainer $dataContainer)
    {
        $dataContainer->setKey(
            'testKey2',
            'test',
            array(
                'anotherKey' => 'another_value'
            )
        );

        $mixResult = $dataContainer->getKey('testKey2', 'test');
        $this->assertTrue(is_array($mixResult));
        $this->assertArrayHasKey('anotherKey', $mixResult);

        // for code coverage
        $dataContainer->setKey(
            'testKey2',
            'test',
            array(
                'anotherKey' => 'another_value'
            )
        );

        $mixResult = $dataContainer->getKey('testKey2', 'test');
        $this->assertTrue(is_array($mixResult));
        $this->assertArrayHasKey('anotherKey', $mixResult);

        return $dataContainer;
    }

    /**
     * test add to key functionality
     *
     * @depends testGetKey
     * @covers  \Asm\Data\DataContainer::add
     * @param  DataContainer $dataContainer
     * @return DataContainer
     */
    public function testAdd(DataContainer $dataContainer)
    {
        $dataContainer->setKey(
            'testKey2',
            'test',
            array(
                'anotherKey' => 'another_value'
            )
        );

        $mixResult = $dataContainer->getKey('testKey2', 'test');
        $this->assertTrue(is_array($mixResult));
        $this->assertArrayHasKey('anotherKey', $mixResult);

        // for code coverage
        $dataContainer->setKey(
            'testKey2',
            'test',
            array(
                'anotherKey' => 'another_value'
            )
        );

        $mixResult = $dataContainer->getKey('testKey2', 'test');
        $this->assertTrue(is_array($mixResult));
        $this->assertArrayHasKey('anotherKey', $mixResult);

        return $dataContainer;
    }

    /**
     * @depends testAddToKey
     * @covers  \Asm\Data\DataContainer::setByArray
     * @param  DataContainer $dataContainer
     * @return DataContainer
     */
    public function testSetByArray(DataContainer $dataContainer)
    {
        $dataContainer->setByArray(
            array(
                'testKey3' => 'test_value_3',
                'testKey4' => 'test_value_4',
                'testKey5' => array('subKey1' => 'sub_val_1'),
                'testKey6' => new \stdClass(),
            )
        );

        $this->assertEquals('test_value_3', $dataContainer->getKey('testKey3'));
        $this->assertEquals('test_value_4', $dataContainer->getKey('testKey4'));
        $this->assertArrayHasKey('subKey1', $dataContainer->getKey('testKey5'));
        $this->assertInstanceOf('stdClass', $dataContainer->getKey('testKey6'));

        return $dataContainer;
    }

    /**
     * @depends testAddToKey
     * @expectedException InvalidArgumentException
     * @param DataContainer $dataContainer
     */
    public function testSetByArrayException(DataContainer $dataContainer)
    {
        $dataContainer->setByArray(array());
    }

    /**
     * @depends testConstruct
     * @covers  \Asm\Data\DataContainer::setByObject
     * @param  DataContainer $dataContainer
     * @return DataContainer
     */
    public function testSetByObject(DataContainer $dataContainer)
    {
        $objParam = new \stdClass();
        $objParam->testProperty1 = 'test_property_value_1';
        $objParam->testProperty2 = 'test_property_value_2';
        $objParam->testProperty3 = array('subkeyPropertyTest' => 'property_value');
        $objParam->testProperty4 = new \stdClass();

        $dataContainer->setByObject($objParam);

        $this->assertEquals('test_property_value_1', $dataContainer->getTestProperty1());
        $this->assertEquals('test_property_value_2', $dataContainer->getTestProperty2());
        $this->assertArrayHasKey('subkeyPropertyTest', $dataContainer->getTestProperty3());
        $this->assertInstanceOf('stdClass', $dataContainer->getTestProperty4());

        return $dataContainer;
    }

    /**
     * @depends testConstruct
     * @expectedException InvalidArgumentException
     * @param DataContainer $dataContainer
     */
    public function testSetByObjectException(DataContainer $dataContainer)
    {
        $dataContainer->setByObject(null);
    }

    /**
     * @depends testSetByArray
     * @covers  \Asm\Data\DataContainer::getAll
     * @param  DataContainer $dataContainer
     * @return DataContainer
     */
    public function testGetAll(DataContainer $dataContainer)
    {
        $mixResult = $dataContainer->toArray();
        $this->assertTrue(is_array($mixResult), 'element is no array');
        $this->assertTrue(0 < count($mixResult), 'no elements in array');
        $this->assertArrayHasKey('testKey3', $mixResult, 'element not in array');

        return $dataContainer;
    }

    /**
     * @depends testSetByArray
     * @covers  \Asm\Data\DataContainer::getAllData
     * @param  DataContainer $dataContainer
     * @return DataContainer
     */
    public function testGetAsArray(DataContainer $dataContainer)
    {
        $mixResult = $dataContainer->getAsArray();
        $this->assertTrue(is_array($mixResult), 'element is no array');
        $this->assertTrue(0 < count($mixResult), 'no elements in array');
        $this->assertArrayHasKey('testKey3', $mixResult, 'element not in array');

        return $dataContainer;
    }

    /**
     * @depends testGetAll
     * @covers  \Asm\Data\DataContainer::normalizeArray
     * @param DataContainer $dataContainer
     */
    public function testNormalizeArray(DataContainer $dataContainer)
    {
        $arrData = array(
            'test_key_3' => 'test_value_3',
            'test_key_4' => 'test_value_4',
            'test_key_5' => array('subKey1' => 'sub_val_1'),
            'test_key_6' => new \stdClass(),
        );

        $arrDataResult = $dataContainer->normalizeArray($arrData);

        $this->assertTrue(is_array($arrDataResult));
        $this->assertArrayHasKey('testKey3', $arrDataResult);
        $this->assertArrayHasKey('testKey4', $arrDataResult);
        $this->assertArrayHasKey('testKey5', $arrDataResult);
        $this->assertArrayHasKey('testKey6', $arrDataResult);
    }

    /**
     * @depends testSetByArray
     * @covers  \Asm\Data\DataContainer::unsetKey
     * @covers  \Asm\Data\DataContainer::_checkKey
     * @param  DataContainer $dataContainer
     * @return DataContainer
     */
    public function testUnsetKey(DataContainer $dataContainer)
    {
        $this->assertArrayHasKey('testKey6', $dataContainer->getAllData());
        $dataContainer->removeKey('testKey6');
        $this->assertFalse($dataContainer->getKey('testKey6'));

        return $dataContainer;
    }

    /**
     * @depends testSetByObject
     * @covers  \Asm\Data\DataContainer::clear
     * @param  DataContainer $dataContainer
     * @return DataContainer
     */
    public function testClear(DataContainer $dataContainer)
    {
        $dataContainer->clear();

        $this->assertFalse($dataContainer->getTestKey1());
        $this->assertFalse($dataContainer->getKey('testKey3'));
        $this->assertFalse($dataContainer->getTestProperty1());

        return $dataContainer;
    }
}
