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
use Symfony\Component\Yaml\Yaml;

/**
 * Class AbstractConfig
 *
 * @package Asm\Config
 * @author marc aschmann <maschmann@gmail.com>
 * @codeCoverageIgnore
 * @uses Asm\Data\Data
 * @uses Symfony\Component\Yaml\Yaml
 */
abstract class AbstractConfig extends Data
{
    /**
     * @var bool
     */
    protected $filecheck = true;

    /**
     * @var string
     */
    private $currentBasepath;

    /**
     * @var array
     */
    protected $imports = [];

    /**
     * @var array
     */
    protected $default = [];

    /**
     * Default constructor.
     *
     * @param array $param
     */
    public function __construct(array $param)
    {
        if (isset($param['filecheck'])) {
            $this->filecheck = (bool)$param['filecheck'];
        }

        $this->setConfig($param['file']);
    }

    /**
     * Add named property to config object
     * and insert config as array.
     *
     * @param string $name name of property
     * @param string $file string $file absolute filepath/filename.ending
     */
    public function addConfig($name, $file)
    {
        $this->set($name, $this->readConfig($file));
    }

    /**
     * Read config file via YAML parser.
     *
     * @param  string $file absolute filepath/filename.ending
     * @return array config array
     */
    public function readConfig($file)
    {
        $this->currentBasepath = dirname($file);

        $config = $this->readFile($file);
        $config = $this->extractImports($config);
        $config = $this->extractDefault($config);
        $this->mergeDefault();

        return array_replace_recursive(
            $this->default,
            $config
        );
    }

    /**
     * Add config to data storage.
     *
     * @param string $file absolute filepath/filename.ending
     */
    public function setConfig($file)
    {
        $this->setByArray(
            array_replace_recursive(
                $this->default,
                $this->readConfig($file)
            )
        );
    }

    /**
     * Read yaml files.
     *
     * @param string $file path/filename
     * @return array
     */
    private function readFile($file)
    {
        if ($this->filecheck && !is_file($file)) {
            throw new \InvalidArgumentException(
                'Config::Abstract() - Given config file ' . $file . ' does not exist!'
            );
        }

        return (array)Yaml::parse($file);
    }

    /**
     * get all import files from config, if set and remove node.
     *
     * @param array $config
     * @return array
     */
    private function extractImports(array $config)
    {
        if (array_key_exists('imports', $config) && 0 < count($config['imports'])) {
            $this->imports = [];
            foreach ($config['imports'] as $key => $import) {
                if (false === empty($import['resource'])) {
                    $this->imports = array_replace_recursive(
                        $this->imports,
                        $this->readFile($this->currentBasepath . '/' . $import['resource'])
                    );
                }
            }

            unset($config['imports']);
        }

        return $config;
    }

    /**
     * Get default values if set and remove node from config.
     *
     * @param array $config
     * @return array
     */
    private function extractDefault($config)
    {
        if (array_key_exists('default', $config)) {
            $this->default = $config['default'];
            unset($config['default']);
        }

        return $config;
    }

    /**
     * Prepare the defaults and replace recursively.
     */
    private function mergeDefault()
    {
        $this->default = array_replace_recursive($this->imports, $this->default);
    }
}
