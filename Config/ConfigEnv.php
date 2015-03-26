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
final class ConfigEnv extends ConfigAbstract implements ConfigInterface
{
    /**
     * @var string
     */
    private $defaultEnv = 'prod';

    /**
     * default constructor
     *
     * @param array $param
     */
    public function __construct(array $param)
    {
        if (isset($param['filecheck'])) {
            $this->filecheck = (bool)$param['filecheck'];
        }

        if (!empty($param['defaultEnv'])) {
            $this->defaultEnv = $param['defaultEnv'];
        }

        $this->mergeEnvironments($param);
    }

    /**
     * merge environments based on defaults array
     * merge order is prod -> lesser environment
     *
     * @param array $param
     */
    private function mergeEnvironments($param)
    {
        $config = new Data();
        $config->setByArray(
            $this->readConfig($param['file'])
        );

        if (!empty($param['env']) && $this->defaultEnv !== $param['env']) {
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
