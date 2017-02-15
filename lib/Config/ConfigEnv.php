<?php
declare(strict_types=1);
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
 * @author Marc Aschmann <maschmann@gmail.com>
 */
final class ConfigEnv extends AbstractConfig implements ConfigInterface
{
    /**
     * @var string
     */
    private $defaultEnv = 'prod';

    /**
     * Default constructor.
     *
     * @param array $param
     */
    public function __construct(array $param)
    {
        if (isset($param[self::FILECHECK])) {
            $this->filecheck = (bool)$param[self::FILECHECK];
        }

        if (!empty($param[self::DEFAULT_ENVIRONMENT])) {
            $this->defaultEnv = $param[self::DEFAULT_ENVIRONMENT];
        }

        $this->mergeEnvironments($param);
    }

    /**
     * Merge environments based on defaults array.
     * Merge order is prod -> lesser environment.
     *
     * @param array $param
     */
    private function mergeEnvironments(array $param)
    {
        $config = new Data();
        $config->setByArray(
            $this->readConfig($param['file'])
        );

        if (!empty($param[self::ENVIRONMENT]) && $this->defaultEnv !== $param[self::ENVIRONMENT]) {
            $toMerge = $config->get($param[self::ENVIRONMENT], []);
            $merged = array_replace_recursive(
                $config->get($this->defaultEnv),
                $toMerge
            );
        } else {
            $merged = $config->get($this->defaultEnv, []);
        }

        $this->setByArray(
            array_replace_recursive(
                $this->default,
                $merged
            )
        );
    }
}
