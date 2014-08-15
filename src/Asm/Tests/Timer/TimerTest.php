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

    /**
     * @depends testConstruct
     * @covers \Asm\Timer\Timer::isTimerActive
     * @covers \Asm\Timer\Timer::checkDate
     * @covers \Asm\Timer\Timer::checkIntervals
     * @covers \Asm\Timer\Timer::checkDays
     * @covers \Asm\Timer\Timer::checkTime
     * @covers \Asm\Timer\Timer::checkHoliday
     * @param Timer $timer
     */
    public function testIsTimerActive(Timer $timer)
    {
        $this->assertTrue(is_bool($timer->isTimerActive('example_timer_config_1')));
        $this->assertTrue(is_bool($timer->isTimerActive('example_timer_config_2')));
        $this->assertTrue(is_bool($timer->isTimerActive('example_timer_config_3')));
        $this->assertTrue(is_bool($timer->isTimerActive('example_timer_config_4')));
        $this->assertTrue(is_bool($timer->isTimerActive('example_timer_config_5')));
        //$this->assertTrue(is_bool($timer->isTimerActive('example_timer_config_6')));
        //$this->assertTrue(is_bool($timer->isTimerActive('general_shipping_promise')));
    }

    /**
     * @depends testConstruct
     * @covers \Asm\Timer\Timer::isHoliday
     * @covers \Asm\Timer\Timer::checkHoliday
     * @param Timer $timer
     */
    public function testIsHoliday(Timer $timer)
    {
        $this->assertFalse($timer->isHoliday('2014-03-03 00:00:00'));
        $this->assertTrue($timer->isHoliday('2014-12-24 12:30:01'));
        $this->assertTrue(is_bool($timer->isHoliday()));
    }
}
