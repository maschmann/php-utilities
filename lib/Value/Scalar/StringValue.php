<?php
declare(strict_types=1);

namespace Asm\Value\Scalar;

use Asm\Exception\InvalidStringException;
use Asm\Value\AbstractBaseValue;
use Asm\Value\StringValueTrait;

/**
 * Class StringValue
 *
 * @package Asm\Value\Scalar
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class StringValue extends AbstractBaseValue
{
    use StringValueTrait;

    /**
     * Do checks based on the type of value.
     *
     * @param mixed $value
     * @throws InvalidStringException
     */
    protected function protect($value)
    {
        if (false === is_string($value)) {
            throw new InvalidStringException($value);
        }
    }
}