<?php
declare(strict_types=1);

namespace Asm\Value;

/**
 * Interface ValueInterface
 *
 * @package Asm\Value
 * @author Marc Aschmann <maschmann@gmail.com>
 */
interface ValueInterface
{
    /**
     * @return mixed
     */
    public function value();
}