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
 * Class ConfigTimerTest
 *
 * @package Asm\Tests\Config
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class ConfigTimerTest extends BaseConfigTest
{
    /**
     * @covers \Asm\Config\ConfigTimer::setConfig
     * @covers \Asm\Config\ConfigTimer::handleTimers
     * @covers \Asm\Config\ConfigTimer::handleHolidays
     * @covers \Asm\Config\ConfigTimer::handleGeneralHolidays
     * @covers \Asm\Test\BaseConfigTest::getTimerYaml
     * @return ConfigTimer $config
     * @throws \ErrorException
     */
    public function testFactory()
    {
        $config = Config::factory(
            [
                'file' => $this->getTimerYaml(),
            ],
            'ConfigTimer'
        );

        $this->assertInstanceOf('Asm\Config\ConfigTimer', $config);

        return $config;
    }
}
