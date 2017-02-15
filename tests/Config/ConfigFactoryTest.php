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
use Asm\Test\BaseConfigTest;

/**
 * Class ConfigFactoryTest
 *
 * @package Asm\Tests\Config
 * @author marc aschmann <marc.aschmann@internetstores.de>
 */
class ConfigFactoryTest extends BaseConfigTest
{

    /**
     * @covers \Asm\Config\Config::factory
     */
    public function testFactory()
    {
        $config = Config::factory(
            [
                'file' => $this->getTestYaml(),
            ],
            'ConfigDefault'
        );

        $this->assertInstanceOf('Asm\Config\ConfigDefault', $config);
    }

    /**
     * @covers \Asm\Config\Config::factory
     */
    public function testFactoryWithoutFilecheck()
    {
        $config = Config::factory(
            [
                'file' => $this->getTestYaml(),
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
                'file' => $this->getTestYaml(),
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
