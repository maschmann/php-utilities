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
class ConfigTimer extends ConfigAbstract implements ConfigInterface
{
    /**
     * default method
     * called by parent::__construct()
     *
     * @param  array $param
     * @return ConfigTimer
     */
    public function init(array $param)
    {
        $this->setConfig($param['file']);

        return $this;
    }

    /**
     * convert config date strings to \DateTime objects or \DateIntervals
     *
     * @param string $file config file
     */
    public function setConfig($file)
    {
        $config = $this->readConfig($file);

        // iterate conf and check if there are dates/datetimes/times and so on, for conversion
        foreach ($config as $timerKey => $timers) {

            switch ($timerKey) {
                case 'timers':
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
                                                    $dateEnd = new \DateTime(
                                                        $intervalValue . ' 23:59:59'
                                                    );
                                                    $config[$timerKey][$timerSubKey][$paramKey][$intervalKey][1] =
                                                        $dateEnd;
                                                //fallthrough
                                                case 2:
                                                    $data = new \DateTime(
                                                        $intervalValue
                                                    );
                                                    $config[$timerKey][$timerSubKey][$paramKey][$intervalKey][$key] =
                                                        $data;
                                                    break;
                                            }

                                        }
                                    }
                                    break;
                                default:
                                    break;
                            }
                        }

                    }

                    break;
                case 'holidays':
                    foreach ($timers as $timerSubKey => $params) {

                        foreach ($params as $paramKey => $paramValue) {
                            $config[$timerKey][$timerSubKey] = array(
                                new \DateTime($paramValue),
                                new \DateTime($paramValue . ' 23:59:59'),
                            );
                        }
                    }
                    break;
                case 'general_holidays':
                    $tmpConf = array();
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
                    $config[$timerKey] = $tmpConf;
            }

        }

        $this->setByArray($config);
    }
}
