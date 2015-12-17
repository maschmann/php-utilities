<?php
/*
 * This file is part of the php-utilities package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asm\Test;

use org\bovigo\vfs\vfsStream;

/**
 * Class BaseConfigTest
 *
 * @package Asm\Test
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class BaseConfigTest extends \PHPUnit_Framework_TestCase
{
    private $root;
    private $configFile;
    private $configImportFile;
    private $configTimerFile;

    /**
     * default setup
     */
    public function setUp()
    {
        parent::setUp();

        $this->root = vfsStream::setup('configs');
        $this->configFile = vfsStream::newFile('default.yml')->at($this->root);
        $this->configFile->setContent(TestData::getYamlImportConfigFile());

        $this->configImportFile = vfsStream::newFile('testimport.yml')->at($this->root);
        $this->configImportFile->setContent(TestData::getYamlImportFile());

        $this->configTimerFile = vfsStream::newFile('testTimer.yml')->at($this->root);
        $this->configTimerFile->setContent(TestData::getYamlTimerConfigFile());
    }

    /**
     * @return mixed
     */
    public function getTestYaml()
    {
        return $this->configFile->url();
    }

    /**
     * @return mixed
     */
    public function getTimerYaml()
    {
        return $this->configTimerFile->url();
    }
}
