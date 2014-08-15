<?php
/*
 * This file is part of the php-utilities package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Asm\Tests\Timer;

use Asm\Config\Config;
use Asm\Test\TestData;
use Asm\Timer\Timer;

/**
 * Class TimerTest
 * @package Asm\Tests\Timer
 * @author marc aschmann <maschmann@gmail.com>
 */
class TimerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Asm\Timer\Timer::__construct
     * @return Timer
     * @throws \ErrorException
     */
    public function testConstruct()
    {
        $config = Config::factory(
            array(
                'file' => TestData::getYamlTimerConfigFile(),
                'filecheck' => false,
            ),
            'ConfigTimer'
        );

        $this->assertInstanceOf('Asm\Config\ConfigTimer', $config);

        $timer = new Timer($config);

        $this->assertInstanceOf('Asm\Timer\Timer', $timer);

        return $timer;
    }
}
