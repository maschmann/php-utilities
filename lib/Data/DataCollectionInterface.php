<?php
declare(strict_types=1);
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
 * Interface DataCollectionInterface
 *
 * @package Asm\Data
 * @author Marc Aschmann <maschmann@gmail.com>
 */
interface DataCollectionInterface extends DataInterface, \Iterator
{
    /**
     * Add element to store.
     *
     * @param  mixed $item
     * @param  int $position
     * @return $this
     */
    public function addItem($item, $position = null);

    /**
     * Get element from store.
     *
     * @param  int $position
     * @return bool|mixed
     */
    public function getItem(int $position = 0);

    /**
     * remove item from position
     * be carefull: this also reindexes the array
     *
     * @param  int $position
     * @return $this
     */
    public function removeItem(int $position);
}
