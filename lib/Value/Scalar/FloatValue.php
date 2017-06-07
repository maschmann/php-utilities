<?php
declare(strict_types=1);

namespace Asm\Value\Scalar;

use Asm\Exception\InvalidFloatException;
use Asm\Value\AbstractBaseValue;

/**
 * Class FloatValue
 *
 * @package Asm\Value\Scalar
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class FloatValue extends AbstractBaseValue
{
    /**
     * Do checks based on the type of value.
     *
     * @param mixed $value
     * @throws InvalidFloatException
     */
    protected function protect($value)
    {
        if (false === is_float($value)) {
            throw new InvalidFloatException($value);
        }
    }
}