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

use Asm\Data\Data;

/**
 * Timer Class
 *
 * @package Asm\Timer
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class Timer
{
    /**
     * @var \Asm\Data\Data
     */
    private $config = null;

    /**
     * current timer's config
     *
     * @var array
     */
    private $currentConf = array();

    /**
     * if a holiday is in place - here it is
     *
     * @var null|\DateTime
     */
    private $holiday = null;

    /**
     * constructor with dependency injection
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new Data();
        $this->config->setByArray($config);

        return $this;
    }

    /**
     * check if timer is active
     *
     * @param  string $strType
     * @return boolean
     */
    public function isTimerActive($strType)
    {
        $return = false;
        $this->currentConf = $this->config->getKey('timers', $strType);

        // pre-check holidays and shop config
        if (empty($this->currentConf['shops']) || in_array($this->system->getShopName(), $this->currentConf['shops'])) {
            if (isset($this->currentConf['holiday'])) {
                // check if shop uses general holiday config
                if (true === $this->currentConf['holiday']['use_general']) {
                    if (false == $this->isHoliday()) {
                        $return = $this->checkDate();
                    }
                } elseif (0 < count($this->config->getKey('holidays', $this->system->getShopName()))) {
                    if (false === $this->checkIntervals(
                            $this->config->getKey('holidays', $this->system->getShopName())
                        )
                    ) {
                        // we're not in a holiday
                        $return = $this->checkDate();
                    }
                }
            } else {
                $return = $this->checkDate();
            }
        }

        return $return;
    }

    /**
     * calculate difference between holiday DateTime objects and current or given time
     *
     * @param  mixed $mixDate
     * @return bool|\DateTime
     */
    public function isHoliday($mixDate = null)
    {
        return $this->checkHoliday($mixDate);
    }

    /**
     * returns holiday object, if set
     *
     * @return \DateTime|null
     */
    public function getHoliday()
    {
        return $this->holiday;
    }

    /**
     * date checks on config
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
     * check for holidays
     *
     * @param  \DateTime|null $mixDate
     * @return bool
     */
    private function checkHoliday($mixDate = null)
    {
        $mixReturn = false;

        if (empty($mixDate)) {
            $today = new \DateTime();
        } else {
            $today = new \DateTime($mixDate);
        }

        foreach ($this->config->getKey('general_holidays') as $holiday) {
            // clone for start/enddate
            $holidayEnd = clone $holiday;
            $holidayStart = clone $holiday;
            $startTime = array(
                '00',
                '00',
                '00',
            );
            $endTime = array(
                '23',
                '59',
                '59',
            );

            if (isset($this->currentConf['holiday']['interval'])) {
                $startTime = explode(':', $this->currentConf['holiday']['interval'][0]);
                $endTime = explode(':', $this->currentConf['holiday']['interval'][1]);
            }

            // check if there's a modifier for holiday range and if it's before or after the actual holiday
            if (isset($this->currentConf['holiday']['additional'])) {
                // creat interval object for difference to add/subtract
                $intervalDiff = new \DateInterval('P' . $this->currentConf['holiday']['additional'][1] . 'D');
                switch ($this->currentConf['holiday']['additional'][0]) {
                    case 'add':
                        // if days are added, date will be enddate
                        $holidayEnd->{$this->currentConf['holiday']['additional'][0]}(
                            $intervalDiff
                        );
                        break;
                    case 'sub':
                        // if days are subtracted, date will be startdate
                        $holidayStart->{$this->currentConf['holiday']['additional'][0]}(
                            $intervalDiff
                        );
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
            if ((1 == $intervalStart->invert)
                && (0 == $intervalEnd->invert)
            ) {
                $this->holiday = $holiday;
                $mixReturn = true;
                break;
            }
        }

        return $mixReturn;
    }

    /**
     * check if current date is in interval
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
            if ((1 == $intervalStart->invert)
                && (0 == $intervalEnd->invert)
            ) {
                $return = true;
                break;
            }
        }

        return $return;
    }

    /**
     * check if today is in days array
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
     * do time comparison
     *
     * @return bool
     */
    private function checkTime()
    {
        $intervals = array();

        foreach ($this->currentConf['time'] as $intKey => $arrTime) {
            // build objects for comparison
            $objStartTime = new \DateTime();
            $startTime = explode(':', $arrTime[0]);
            $intervals[$intKey][0] = $objStartTime->setTime(
                $startTime[0],
                $startTime[1],
                $startTime[2]
            );

            $objEndTime = new \DateTime();
            $endTime = explode(':', $arrTime[1]);
            $intervals[$intKey][1] = $objEndTime->setTime(
                $endTime[0],
                $endTime[1],
                $endTime[2]
            );
        }

        return $this->checkIntervals($intervals);
    }
}
