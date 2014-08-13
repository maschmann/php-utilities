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

$config = Config\Config::factory(
    array(
        'file' => 'test.yml'
    ),
    'ConfigDefault'
);

echo print_r($data, true) . "\n";
