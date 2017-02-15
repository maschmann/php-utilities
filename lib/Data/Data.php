<?php
/*
 * This file is part of the php-utilities package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Asm\Data;

/**
 * Class Data
 *
 * @package Asm\Data
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class Data implements DataInterface
{
    use DataTrait;

    /**
     * Normalize a key.
     *
     * @param  string $key
     * @return string
     */
    public static function normalize($key)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
    }
}
