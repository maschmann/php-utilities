<?php
/*
 * This file is part of the php-utilities package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Asm\Timer;

use Asm\Config\ConfigTimer;

/**
 * Timer Class
 *
 * @package Asm\Timer
 * @author Marc Aschmann <maschmann@gmail.com>
 */
final class Timer
{
    /**
     * @var \Asm\Data\Data
     */
    private $config;

    /**
     * Current timer's config.
     *
     * @var mixed
     */
    private $currentConf;

    /**
     * If a holiday is in place - here it is.
     *
     * @var null|\DateTime
     */
    private $holiday;

    /**
     * Constructor with dependency injection.
     *
     * @param ConfigTimer $config
     */
    public function __construct(ConfigTimer $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Check if timer is active.
     *
     * @param  string $type
     * @return boolean
     */
    public function isTimerActive($type)
    {
        $return = false;
        $this->currentConf = $this->config->get('timers', $type);

        // pre-check holidays
        if (true === isset($this->currentConf['holiday'])) {
            // check if general holidays are to be used
            if (isset($this->currentConf['holiday']['use_general'])
                && true === (bool)$this->currentConf['holiday']['use_general']
            ) {
                if (false == $this->isHoliday()) {
                    $return = $this->checkDate();
                }
            } elseif (0 < count($this->config->get('holidays'))) {
                if (false === $this->checkIntervals($this->config->get('holidays'))) {
                    // we're not in a holiday
                    $return = $this->checkDate();
                }
            }
        } else {
            $return = $this->checkDate();
        }

        $this->flush();
        return $return;
    }

    /**
     * Calculate difference between holiday DateTime objects and current or given time.
     *
     * @param  string|null $date
     * @return boolean
     */
    public function isHoliday($date = null)
    {
        return $this->checkHoliday($date);
    }

    /**
     * Returns holiday object, if set.
     *
     * @codeCoverageIgnore
     * @return \DateTime|null
     */
    public function getHoliday()
    {
        return $this->holiday;
    }

    /**
     * Clear current configuration.
     */
    public function flush()
    {
        $this->currentConf = array();
        $this->holiday = null;
    }

    /**
     * Date checks on config.
     *
     * @return bool
     */
    private function checkDate()
    {
        $return = false;

        // reverse switch to call checks
        switch (true) {
            case array_key_exists('interval', $this->currentConf):
                $return = $this->checkIntervals();
                break;
            case (array_key_exists('time', $this->currentConf) && array_key_exists('day', $this->currentConf)):
                // first check if we're on configured day
                if (true == $this->checkDays()) {
                    // then see if we're in the timeframe
                    $return = $this->checkTime();
                }
                break;
            case array_key_exists('day', $this->currentConf):
                $return = $this->checkDays();
                break;
            case array_key_exists('time', $this->currentConf):
                $return = $this->checkTime();
                break;
        }

        return $return;
    }

    /**
     * Check for holidays.
     *
     * @param  string|null $date
     * @return bool
     */
    private function checkHoliday($date = null)
    {
        $mixReturn = false;

        $today = $this->convertDate($date);

        foreach ($this->config->get('general_holidays') as $holiday) {
            // clone for start/enddate
            $holidayEnd = clone $holiday;
            $holidayStart = clone $holiday;
            $startTime = array('00', '00', '00');
            $endTime = array('23', '59', '59');

            if (true === isset($this->currentConf['holiday']['interval'])) {
                $startTime = explode(':', $this->currentConf['holiday']['interval'][0]);
                $endTime = explode(':', $this->currentConf['holiday']['interval'][1]);
            }

            // check if there's a modifier for holiday range and if it's before or after the actual holiday
            if (isset($this->currentConf['holiday']['additional'])) {
                // create interval object for difference to add/subtract
                $intervalDiff = new \DateInterval('P' . $this->currentConf['holiday']['additional'][1] . 'D');
                switch ($this->currentConf['holiday']['additional'][0]) {
                    case 'add':
                        // if days are added, date will be enddate
                        $holidayEnd->{$this->currentConf['holiday']['additional'][0]}($intervalDiff);
                        break;
                    case 'sub':
                        // if days are subtracted, date will be startdate
                        $holidayStart->{$this->currentConf['holiday']['additional'][0]}($intervalDiff);
                        break;
                }
            }

            // calculate difference between today and timed startdate
            $intervalStart = $today->diff(
                $holidayStart->setTime($startTime[0], $startTime[1], $startTime[2])
            );
            // calculate difference between today and timed enddate
            $intervalEnd = $today->diff(
                $holidayEnd->setTime($endTime[0], $endTime[1], $endTime[2])
            );

            // check if current date has passed start but not endtime
            if ((1 == $intervalStart->invert) && (0 == $intervalEnd->invert)) {
                $this->holiday = $holiday;
                $mixReturn = true;
                break;
            }
        }

        return $mixReturn;
    }

    /**
     * Check if current date is in interval.
     *
     * @param  array $intervals
     * @return bool
     */
    private function checkIntervals(array $intervals = array())
    {
        $today = new \DateTime();
        $return = false;

        if (empty($intervals)) {
            $intervals = $this->currentConf['interval'];
        }

        foreach ($intervals as $interval) {
            $intervalStart = $today->diff($interval[0]);
            $intervalEnd = $today->diff($interval[1]);

            // check if current date has passed start but not endtime
            if ((1 == $intervalStart->invert) && (0 == $intervalEnd->invert)) {
                $return = true;
                break;
            }
        }

        return $return;
    }

    /**
     * Check if today is in days array.
     *
     * @return bool
     */
    private function checkDays()
    {
        $return = false;

        if (in_array(strtolower(date('l')), $this->currentConf['day'])) {
            $return = true;
        }

        return $return;
    }

    /**
     * Do time comparison.
     *
     * @param array $intervals
     * @return bool
     */
    private function checkTime($intervals = array())
    {
        $return = array();
        if (empty($intervals)) {
            $intervals = $this->currentConf['time'];
        }

        foreach ($intervals as $intKey => $intervalParts) {
            // build objects for comparison
            $startTime = new \DateTime();
            $startTimeParts = explode(':', $intervalParts[0]);

            $return[$intKey][0] = $startTime->setTime(
                $startTimeParts[0],
                $startTimeParts[1],
                $startTimeParts[2]
            );

            $endTime = new \DateTime();
            $endTimeParts = explode(':', $intervalParts[1]);
            $return[$intKey][1] = $endTime->setTime(
                $endTimeParts[0],
                $endTimeParts[1],
                $endTimeParts[2]
            );
        }

        return $this->checkIntervals($return);
    }

    /**
     * Check date string or object and convert if necessary.
     *
     * @param mixed $date
     * @return \DateTime
     */
    private function convertDate($date)
    {
        if (empty($date)) {
            $today = new \DateTime();
        } else {
            $today = new \DateTime($date);
        }

        return $today;
    }
}
