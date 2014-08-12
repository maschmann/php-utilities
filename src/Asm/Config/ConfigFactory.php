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
 * Class ConfigManager
 *
 * @package Asm\Config
 * @author marc aschmann <maschmann@gmail.com>
 */
class ConfigFactory
{
    /**
     * get object of specific class
     *
     * @param  string $file config file name
     * @param  string $class name of class without
     * @throws \ErrorException
     * @throws \InvalidArgumentException
     * @return ConfigInterface
     */
    public static function factory($file, $class = 'ConfigDefault')
    {
        if (false === strpos($class, 'Asm')) {
            $class = __NAMESPACE__ . '\\' . $class;
        }

        if (class_exists($class)) {
            // allow config names without ending
            if (false === strpos($file, '.yml')) {
                $file = $file . '.yml';
            }

            return new $class($file);
        } else {
            throw new \ErrorException('could not instantiate ' . $class . ' - not in self::$arrClassWhitelist');
        }
    }

    /**
     * fordbid instantiation
     */
    private function __construct()
    {

    }

    /**
     * forbid cloning
     */
    private function __clone()
    {

    }
}
