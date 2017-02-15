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

use Asm\Data\DataInterface;

/**
 * Interface ConfigInterface
 *
 * @package Asm\Config
 * @author Marc Aschmann <maschmann@gmail.com>
 * @uses Asm\Data\DataInterface
 * @codeCoverageIgnore
 */
interface ConfigInterface extends DataInterface
{
    /**
     * Add named property to config object
     * and insert config as array.
     *
     * @param string $name name of property
     * @param string $file string $file absolute filepath/filename.ending
     * @return $this
     */
    public function addConfig(string $name, string $file);

    /**
     * Add config to data storage.
     *
     * @param string $file absolute filepath/filename.ending
     * @return $this
     */
    public function setConfig(string $file);

    /**
     * Read config file via YAML parser.
     *
     * @param string $file absolute filepath/filename.ending
     * @return array  config array
     */
    public function readConfig(string $file) : array;
}
