<?php
declare(strict_types=1);
/*
 * This file is part of the asm/php-utilities package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asm\Value;

use Asm\Exception\TypeNotFoundException;
use Asm\Value\Scalar\BoolValue;
use Asm\Value\Scalar\FloatValue;
use Asm\Value\Scalar\IntValue;
use Asm\Value\Scalar\NaturalNumberValue;
use Asm\Value\Scalar\StringValue;

/**
 * Value object factory
 *
 * @package Asm\Value
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class Value
{
    /**
     * Tries to determine type of value and create an according object
     *
     * Since natural numbers are a subset of int and float, we can not
     * determine if the value should be int, float or a natural number
     * (which would be most cases, anyway)
     *
     * @param mixed $value
     * @return ValueInterface
     * @throws TypeNotFoundException
     */
    public static function build($value)
    {
        switch (true) {
            case is_string($value):
                $value = new StringValue($value);
                break;
            case is_int($value):
                $value = new IntValue($value);
                break;
            case is_float($value):
                $value = new FloatValue($value);
                break;
            case is_bool($value):
                $value = new BoolValue($value);
                break;
            default:
                throw new TypeNotFoundException($value);
        }

        return $value;
    }
}
