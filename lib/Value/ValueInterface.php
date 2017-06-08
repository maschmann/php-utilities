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
