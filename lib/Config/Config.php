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

use Asm\Exception\ConfigClassNotExistsException;
use Asm\Exception\ConfigParameterMissingException;

/**
 * Class Config
 *
 * @package Asm\Config
 * @author Marc Aschmann <maschmann@gmail.com>
 */
final class Config
{
    const DEFAULT_CONFIG = 'ConfigDefault';
    const DEFAULT_NAMESPACE = 'Asm';

    /**
     * Get object of specific class.
     *
     * @param  array $param config file name
     * @param  string $class name of class without
     * @throws \ErrorException
     * @throws \InvalidArgumentException
     * @return ConfigInterface
     */
    public static function factory(array $param, string $class = self::DEFAULT_CONFIG) : ConfigInterface
    {
        if (false === strpos($class, self::DEFAULT_NAMESPACE)) {
            $class = __NAMESPACE__ . '\\' . $class;
        }

        if (class_exists($class)) {
            // allow config names without ending
            if (empty($param['file'])) {
                throw new ConfigParameterMissingException(
                    'Config::factory() - config filename missing in param array!'
                );
            }

            return new $class($param);
        } else {
            throw new ConfigClassNotExistsException(
                "Config::factory() - could not instantiate {$class}, does not exist!"
            );
        }
    }

    /**
     * Fordbid instantiation.
     *
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * Forbid cloning.
     *
     * @codeCoverageIgnore
     */
    private function __clone()
    {
    }
}
