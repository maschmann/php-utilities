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
     * @return \Asm\Config\ConfigTimer
     */
    public function init(array $param)
    {
        $this->setConfig($param['file']);

        return $this;
    }

    /**
     * convert config file to properties of config object
     *
     * @param string $file absolute filepath/filename.ending
     */
    public function setConfig($file)
    {
        $arrConf = $this->readConfig($file);

        // iterate conf and check if there are dates/datetimes/times and so on, for conversion
        foreach ($arrConf as $strTimerKey => $arrTimer) {

            switch ($strTimerKey) {
                case 'timers':

                    foreach ($arrTimer as $strTimerSubKey => $params) {

                        foreach ($params as $strParamKey => $mixParamVal) {
                            switch ($strParamKey) {
                                case 'interval':

                                    // check the contents of interval
                                    foreach ($mixParamVal as $intIntervalKey => $arrInterval) {

                                        // convert all sub elements
                                        foreach ($arrInterval as $intKey => $mixIntervalVal) {

                                            // just a date, no time - one element
                                            switch (count($arrInterval)) {
                                                case 1:
                                                    $objDateEnd                                                               = new \DateTime(
                                                        $mixIntervalVal . ' 23:59:59'
                                                    );
                                                    $arrConf[$strTimerKey][$strTimerSubKey][$strParamKey][$intIntervalKey][1] = $objDateEnd;
                                                case 2:
                                                    $objDate                                                                        = new \DateTime(
                                                        $mixIntervalVal
                                                    );
                                                    $arrConf[$strTimerKey][$strTimerSubKey][$strParamKey][$intIntervalKey][$intKey] = $objDate;
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
                    foreach ($arrTimer as $strTimerSubKey => $params) {

                        foreach ($params as $intParamKey => $strParamVal) {
                            $arrConf[$strTimerKey][$strTimerSubKey][$intParamKey] = array(
                                new \DateTime($strParamVal),
                                new \DateTime($strParamVal . ' 23:59:59'),
                            );
                        }
                    }
                    break;
                case 'general_holidays':
                    $arrTmpConf = array();
                    $strYear    = date('Y');
                    // get server's easter date for later calculation
                    $objEasterDate = new \DateTime(date('Y-m-d', easter_date($strYear)));

                    foreach ($arrTimer as $params) {
                        switch ($params['type']) {
                            case 'fix':
                                $arrTmpConf[$params['name']] = new \DateTime(
                                    $strYear . '-' . $params['value'][0] . '-' . $params['value'][1]
                                );
                                break;
                            case 'var':
                                $objEasterDateClone             = clone $objEasterDate;
                                $arrTmpConf[$params['name']] = $objEasterDateClone->{$params['value'][0]}(
                                    new \DateInterval('P' . $params['value'][1] . 'D')
                                );
                                break;
                        }
                    }
                    $arrConf[$strTimerKey] = $arrTmpConf;
            }

        }

        $this->setByArray($arrConf);
    }
}
