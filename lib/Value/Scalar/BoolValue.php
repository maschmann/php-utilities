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
