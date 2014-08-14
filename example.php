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

$file = <<<EOT
prod:
    testkey_1: 'testvalue'
    testkey_2:
        - dummy1
        - dummy2
        - dummy3
    testkey_3:
        subkey_1: subvalue1
        subkey_2: 123
        subkey_3: ~

stage: []
test: []
dev:
    testkey_2:
        - 25
        - 69
EOT;

// default config
$config = Config\Config::factory(
    array(
        'file' => $file,
        'filecheck' => false,
    ),
    'ConfigDefault'
);

echo print_r($config, true) . "\n";

// merged environments config
$config = Config\Config::factory(
    array(
        'file' => $file,
        'filecheck' => false,
    ),
    'ConfigEnv'
);

echo print_r($config, true) . "\n";

// merged environments config using dev
$config = Config\Config::factory(
    array(
        'file' => $file,
        'filecheck' => false,
        'env' => 'dev',
    ),
    'ConfigEnv'
);

echo print_r($config, true) . "\n";
