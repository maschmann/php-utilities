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

/**
 * Special handling for string values
 *
 * @package Asm\Value
 * @author Marc Aschmann <maschmann@gmail.com>
 */
trait StringValueTrait
{
    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->value;
    }
}