<?php
/*
 * This file is part of the php-utilities package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Asm\Config;

/**
 * Class ConfigTimer
 *
 * @package Asm\Config
 * @author marc aschmann <maschmann@gmail.com>
 */
final class ConfigTimer extends ConfigAbstract implements ConfigInterface
{
    /**
     * Convert config date strings to \DateTime objects or \DateIntervals.
     *
     * @param string $file config file
     */
    public function setConfig($file)
    {
        // iterate conf and check if there are dates/datetimes/times and so on, for conversion
        foreach ($this->readConfig($file) as $timerKey => $timers) {
            switch ($timerKey) {
                case 'timers':
                    $this->handleTimers($timers, $timerKey);
                    break;
                case 'holidays':
                    $this->handleHolidays($timers, $timerKey);
                    break;
                case 'general_holidays':
                    $this->handleGeneralHolidays($timers, $timerKey);
                    break;
                default:
                    $this->set($timerKey, $timers);
                    break;
            }
        }
    }

    /**
     * Generate Datetime objects from config values.
     *
     * @param array $timers
     * @param string $timerKey
     */
    private function handleTimers(array $timers, $timerKey)
    {
        foreach ($timers as $timerSubKey => $params) {
            foreach ($params as $paramKey => $paramVal) {
                switch ($paramKey) {
                    case 'interval':
                        // check the contents of interval
                        foreach ($paramVal as $intervalKey => $interval) {
                            // convert all sub elements
                            foreach ($interval as $key => $intervalValue) {
                                // just a date, no time - one element
                                switch (count($interval)) {
                                    case 1:
                                        $this->set(
                                            $timerKey,
                                            $timerSubKey,
                                            $paramKey,
                                            $intervalKey,
                                            1,
                                            new \DateTime(
                                                $intervalValue . ' 23:59:59'
                                            )
                                        );
                                    //fallthrough
                                    case 2:
                                        $this->set(
                                            $timerKey,
                                            $timerSubKey,
                                            $paramKey,
                                            $intervalKey,
                                            $key,
                                            new \DateTime(
                                                $intervalValue
                                            )
                                        );
                                        break;
                                }
                            }
                        }
                        break;
                    default:
                        $this->set($timerKey, $timerSubKey, $paramKey, $paramVal);
                        break;
                }
            }
        }
    }

    /**
     * Generate holiday DateTime objects for config.
     *
     * @param array $timers
     * @param mixed $timerKey
     */
    private function handleHolidays(array $timers, $timerKey)
    {
        foreach ($timers as $timerSubKey => $params) {
            foreach ($params as $paramKey => $paramValue) {
                $this->set(
                    $timerKey,
                    $timerSubKey,
                    [
                        new \DateTime($paramValue),
                        new \DateTime($paramValue . ' 23:59:59'),
                    ]
                );
            }
        }
    }

    /**
     * Handle holiday list and covert to DateTime where possible.
     *
     * @param array $timers
     * @param mixed $timerKey
     */
    private function handleGeneralHolidays(array $timers, $timerKey)
    {
        $tmpConf = [];
        $year    = date('Y');
        // get server's easter date for later calculation
        $easterDate = new \DateTime(date('Y-m-d', easter_date($year)));

        foreach ($timers as $params) {
            switch ($params['type']) {
                case 'fix':
                    $tmpConf[$params['name']] = new \DateTime(
                        $year . '-' . $params['value'][0] . '-' . $params['value'][1]
                    );
                    break;
                case 'var':
                    $easterDateClone = clone $easterDate;
                    $tmpConf[$params['name']] = $easterDateClone->{$params['value'][0]}(
                        new \DateInterval('P' . $params['value'][1] . 'D')
                    );
                    break;
            }
        }

        $this->set($timerKey, $tmpConf);
    }
}
