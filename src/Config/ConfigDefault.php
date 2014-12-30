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
 * Class ConfigDefault
 *
 * @package Asm\Config
 * @author marc aschmann <maschmann@gmail.com>
 */
final class ConfigDefault extends ConfigAbstract implements ConfigInterface
{
    /**
     * default method
     * called by parent::__construct()
     *
     * @param  array $param
     * @return \Asm\Config\ConfigDefault
     */
    public function init(array $param)
    {
        $this->setConfig($param['file']);

        return $this;
    }
}
