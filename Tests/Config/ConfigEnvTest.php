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
use Asm\Config\ConfigEnv;
use Asm\Test\BaseConfigTest;
use Asm\Test\TestData;

/**
 * Class ConfigEnvTest
 *
 * @package Asm\Tests\Config
 * @author marc aschmann <marc.aschmann@internetstores.de>
 */
class ConfigEnvTest extends BaseConfigTest
{
    /**
     * @covers \Asm\Config\ConfigEnv::mergeEnvironments
     * @covers \Asm\Config\ConfigEnv::__construct
     * @return \Asm\Config\ConfigInterface
     */
    public function testFactoryProd()
    {
        // merged environments config
        $config = Config::factory(
            [
                'file' => $this->getTestYaml(),
                'filecheck' => false,
            ],
            'ConfigEnv'
        );

        $this->assertInstanceOf('Asm\Config\ConfigEnv', $config);

        return $config;
    }

    /**
     * @covers \Asm\Config\ConfigEnv::mergeEnvironments
     * @covers \Asm\Config\ConfigEnv::__construct
     * @return \Asm\Config\ConfigInterface
     */
    public function testFactoryEnv()
    {
        $config = Config::factory(
            [
                'file' => TestData::getYamlConfigFile(),
                'filecheck' => false,
                'defaultEnv' => 'prod',
                'env' => 'dev',
            ],
            'ConfigEnv'
        );

        $this->assertInstanceOf('Asm\Config\ConfigEnv', $config);

        return $config;
    }

    /**
     * @depends testFactoryEnv
     * @param ConfigEnv $config
     */
    public function testConfigMerge(ConfigEnv $config)
    {
        $this->assertEquals(25, $config->get('testkey_2', 0));
    }
}
