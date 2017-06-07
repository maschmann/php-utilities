<?php
declare(strict_types=1);

namespace Asm\Value\Scalar;

use Asm\Exception\InvalidBooleanException;
use Asm\Value\AbstractBaseValue;

/**
 * Class BoolValue
 *
 * @package Asm\Value\Scalar
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class BoolValue extends AbstractBaseValue
{
    /**
     * Do checks based on the type of value.
     *
     * @param mixed $value
     * @throws InvalidBooleanException
     */
    protected function protect($value)
    {
        if (false === is_bool($value)) {
            throw new InvalidBooleanException($value);
        }
    }
}