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
 * Interface ConfigInterface
 *
 * @package Asm\Config
 * @author marc aschmann <maschmann@gmail.com>
 */
interface ConfigInterface
{
    /**
     * abstract init
     * behaves like an interface and enforces implementation in child class
     *
     * @param array $param
     */
    public function init(array $param);

    /**
     * add named property to config object
     * and insert config as array
     *
     * @param string $name name of property
     * @param string $file string $file absolute filepath/filename.ending
     */
    public function addconfig($name, $file);

    /**
     * add config to data storage
     *
     * @param string $file absolute filepath/filename.ending
     */
    public function setConfig($file);

    /**
     * read config file via YAML parser
     *
     * @param string $file absolute filepath/filename.ending
     * @return array  config array
     */
    public function readConfig($file);
}
