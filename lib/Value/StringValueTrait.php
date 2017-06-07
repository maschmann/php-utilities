<?php
declare(strict_types=1);

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