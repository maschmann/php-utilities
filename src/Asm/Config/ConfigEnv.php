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

use Asm\Data\Data;

/**
 * Class ConfigDefault
 *
 * @package Asm\Config
 * @author marc aschmann <maschmann@gmail.com>
 */
class ConfigEnv extends ConfigAbstract implements ConfigInterface
{
    /**
     * @var string
     */
    protected $defaultEnv = 'prod';

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
     * change default env.
     * default env is the base/blueprint for merging
     *
     * @param $env
     */
    public function setDefaultEnv($env)
    {
        $this->defaultEnv = $env;
    }

    /**
     * merge environments based on defaults array
     * merge order is prod -> lesser environment
     *
     * @param $param
     */
    private function mergeEnvironments($param)
    {
        $config = new Data();
        $config->setByArray(
            $this->readConfig($param['file'])
        );

        if (isset($param['env']) && $this->defaultEnv !== $param['env']) {
            $toMerge = $config->get($param['env'], array());
            $merged = array_replace_recursive(
                $config->get($this->defaultEnv),
                $toMerge
            );
        } else {
            $merged = $config->get($this->defaultEnv);
        }

        $this->setByArray($merged);
    }
}
