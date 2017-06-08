<?php
declare(strict_types=1);
/*
 * This file is part of the <package> package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asm\Data;

use Asm\Value\Value;

/**
 * Class DataNode
 *
 * @package Asm\Data
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class DataNode
{
    /**
     * @param mixed $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->{$name} = Value::build($value);
    }

    /**
     * @param mixed $name
     * @return bool
     */
    public function has($name): bool
    {
        return property_exists($this, $name);
    }
}
