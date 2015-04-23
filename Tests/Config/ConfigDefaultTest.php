<?php
/*
 * This file is part of the php-utilities package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Asm\Tests\Config;

use Asm\Config\Config;
use Asm\Config\ConfigDefault;
use Asm\Test\BaseConfigTest;

/**
 * Class ConfigDefaultTest
 *
 * @package Asm\Tests\Config
 * @author marc aschmann <marc.aschmann@internetstores.de>
 */
class ConfigDefaultTest extends BaseConfigTest
{
    /**
     * @covers \Asm\Config\ConfigAbstract::readConfig
     * @covers \Asm\Config\ConfigAbstract::setConfig
     */
    public function testFactory()
    {
        $config = Config::factory(
            [
                'file' => $this->getTestYaml(),
                'filecheck' => false,
            ],
            'ConfigDefault'
        );

        $this->assertInstanceOf('Asm\Config\ConfigDefault', $config);
    }
}
