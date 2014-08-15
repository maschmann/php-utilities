<?php
/*
 * This file is part of the php-utilities package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Asm\Tests\Test;

use Asm\Test\TestData;

/**
 * Class TestDataTest
 *
 * @package Asm\Tests\Test
 * @author marc aschmann <maschmann@gmail.com>
 */
class TestDataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Asm\Test\TestData::getYamlConfigFile
     */
    public function testGetYamlConfigFile()
    {
        $this->assertNotEmpty(TestData::getYamlConfigFile());
        $this->assertContains('testkey_1:', TestData::getYamlConfigFile());
    }

    /**
     * @covers \Asm\Test\TestData::getYamlTimerConfigFile
     */
    public function testGetYamlTimerConfigFile()
    {
        $this->assertNotEmpty(TestData::getYamlTimerConfigFile());
    }
}
