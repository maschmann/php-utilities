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

class ConfigTimerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Asm\Config\ConfigTimer::setConfig
     * @return ConfigTimer $config
     * @throws \ErrorException
     */
    public function testFactory()
    {
        $config = Config::factory(
            array(
                'file' => TestData::getYamlTimerConfigFile(),
                'filecheck' => false,
            ),
            'ConfigTimer'
        );

        $this->assertInstanceOf('Asm\Config\ConfigTimer', $config);

        return $config;
    }
}
