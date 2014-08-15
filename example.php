<?php
/*
 * This file is part of the php-utilities package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require "./vendor/autoload.php";

use Asm\Data;
use Asm\Config;
use Asm\Test\TestData;

$data = new Data\Data();
$data->setByArray(
    array(
        'test_1' => 'somevalue',
        'test_2' => array(
            'subtest_1' => 'more_value',
            'subtest_3' => 25,
        ),
    )
);

echo print_r($data, true) . "\n";


// default config
$config = Config\Config::factory(
    array(
        'file' => TestData::getYamlConfigFile(),
        'filecheck' => false,
    ),
    'ConfigDefault'
);

echo print_r($config, true) . "\n";

// merged environments config
$config = Config\Config::factory(
    array(
        'file' => TestData::getYamlConfigFile(),
        'filecheck' => false,
    ),
    'ConfigEnv'
);

echo print_r($config, true) . "\n";

// merged environments config using dev
$config = Config\Config::factory(
    array(
        'file' => TestData::getYamlConfigFile(),
        'filecheck' => false,
        'env' => 'dev',
    ),
    'ConfigEnv'
);

echo print_r($config, true) . "\n";

// timer config
$config = Config\Config::factory(
    array(
        'file' => TestData::getYamlTimerConfigFile(),
        'filecheck' => false,
    ),
    'ConfigTimer'
);

echo print_r($config, true) . "\n";
