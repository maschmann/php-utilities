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
class ConfigEnv extends ConfigAbstract implements ConfigInterface
{
    private $defaults = array(
        'prod',
        'stage',
        'test',
        'dev',
    );

    /**
     * default method
     * called by parent::__construct()
     *
     * @param  array $param
     * @return \Asm\Config\ConfigEnv
     */
    public function init(array $param)
    {
        $this->mergeEnvironments($param);

        return $this;
    }

    /**
     * merge environments based on defaults array
     * merge order is prod -> lesser environment
     *
     * @param $param
     */
    private function mergeEnvironments($param)
    {
        $this->setConfig($param['file']);
    }
}
