<?php
/*
 * This file is part of the php-utilities package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Asm\Tests\Config;

use Asm\Config\Config;
use Asm\Test\TestData;

/**
 * Class ConfigFactoryTest
 *
 * @package Asm\Tests\Config
 * @author marc aschmann <marc.aschmann@internetstores.de>
 */
class ConfigFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Asm\Config\Config::factory
     */
    public function testFactory()
    {
        $config = Config::factory(
            [
                'file' => TestData::getYamlConfigFile(),
                'filecheck' => false,
            ],
            'ConfigDefault'
        );

        $this->assertInstanceOf('Asm\Config\ConfigDefault', $config);
    }

    /**
     * @expectedException \ErrorException
     * @throws \ErrorException
     */
    public function testFactoryErrorException()
    {
        $config = Config::factory(
            [
                'file' => TestData::getYamlConfigFile(),
                'filecheck' => false,
            ],
            'ConfigXXX'
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @throws \InvalidArgumentException
     */
    public function testFactoryInvalidArgumentException()
    {
        $config = Config::factory(
            [],
            'ConfigDefault'
        );
    }
}
