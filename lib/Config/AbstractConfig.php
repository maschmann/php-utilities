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
use Asm\Exception\InvalidConfigFileException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class AbstractConfig
 *
 * @package Asm\Config
 * @author Marc Aschmann <maschmann@gmail.com>
 * @codeCoverageIgnore
 * @uses Asm\Data\Data
 * @uses Symfony\Component\Yaml\Yaml
 */
abstract class AbstractConfig extends Data
{
    const IMPORTS = 'imports';
    const FILECHECK = 'filecheck';
    const FILE = 'file';
    const RESOURCE = 'resource';
    const DEFAULT = 'default';
    const DEFAULT_ENVIRONMENT = 'defaultEnv';
    const ENVIRONMENT = 'env';

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
        if (isset($param[self::FILECHECK])) {
            $this->filecheck = (bool)$param[self::FILECHECK];
        }

        $this->setConfig($param['file']);
    }

    /**
     * Add named property to config object
     * and insert config as array.
     *
     * @param string $name name of property
     * @param string $file string $file absolute filepath/filename.ending
     * @return $this
     */
    public function addConfig(string $name, string $file)
    {
        $this->set($name, $this->readConfig($file));

        return $this;
    }

    /**
     * Read config file via YAML parser.
     *
     * @param  string $file absolute filepath/filename.ending
     * @return array config array
     */
    public function readConfig(string $file) : array
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
     * @return $this
     */
    public function setConfig(string $file)
    {
        $this->setByArray(
            array_replace_recursive(
                $this->default,
                $this->readConfig($file)
            )
        );

        return $this;
    }

    /**
     * Read yaml files.
     *
     * @param string $file path/filename
     * @return array
     */
    private function readFile(string $file) : array
    {
        if ($this->filecheck) {
            if (is_file($file)) {
                $file = file_get_contents($file);
            } else {
                throw new InvalidConfigFileException(
                    "Config::Abstract() - Given config file {$file} does not exist!"
                );
            }
        }

        return (array)Yaml::parse($file);
    }

    /**
     * get all import files from config, if set and remove node.
     *
     * @param array $config
     * @return array
     */
    private function extractImports(array $config) : array
    {
        if (array_key_exists(self::IMPORTS, $config) && 0 < count($config[self::IMPORTS])) {
            $this->imports = [];
            foreach ($config[self::IMPORTS] as $key => $import) {
                if (false === empty($import[self::RESOURCE])) {
                    $include = $this->checkPath($import[self::RESOURCE]);

                    $this->imports = array_replace_recursive(
                        $this->imports,
                        $this->readFile($include)
                    );
                }
            }

            unset($config[self::IMPORTS]);
        }

        return $config;
    }

    /**
     * Get default values if set and remove node from config.
     *
     * @param array $config
     * @return array
     */
    private function extractDefault(array $config) : array
    {
        if (array_key_exists(self::DEFAULT, $config)) {
            $this->default = $config[self::DEFAULT];
            unset($config[self::DEFAULT]);
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

    /**
     * Only add basepath if not already in filename.
     *
     * @param string $include
     * @return string
     */
    private function checkPath(string $include) : string
    {
        if (0 !== strpos($include, $this->currentBasepath)) {
            $include = $this->currentBasepath . '/' . $include;
        }

        return $include;
    }
}
