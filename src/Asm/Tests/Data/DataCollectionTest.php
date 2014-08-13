<?php
/**
 * @namespace
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
     * @return DataCollection
     */
    public function testConstruct()
    {
        $dataCollection = new DataCollection();
        $this->assertInstanceOf('\Asm\Data\DataCollection', $dataCollection);

        return $dataCollection;
    }
}
