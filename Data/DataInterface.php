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
 * Interface DataInterface
 *
 * @package Asm\Data
 * @author marc aschmann <maschmann@gmail.com>
 */
interface DataInterface
{
    /**
     * Remove all data from internal array.
     *
     * @return $this
     */
    public function clear();

    /**
     * Generic set method for multidimensional storage.
     *
     * $this->set( $key1, $key2, $key3, ..., $mixVal )
     *
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function set();

    /**
     * Add array content by iteration to interal array.
     *
     * @param  array $param
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setByArray(array $param);

    /**
     * Adds given object's properties to interal array.
     *
     * @param  object $param
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setByObject($param);

    /**
     * Fill datastore by json string.
     *
     * @param string $json
     * @return mixed
     */
    public function setByJson($json);

    /**
     * Multidimensional getter.
     *
     * Find a key structure in a multidimensional array and return the value
     * params are stackable -> get( $k1, $k2, $k3, ... ).
     *
     * @return bool|mixed
     */
    public function get();

    /**
     * Remove key from internal storage.
     *
     * @param string $key
     * @return $this
     */
    public function remove($key);

    /**
     * Get all firstlevel keys of interal array.
     *
     * @return array keylist
     */
    public function getKeys();

    /**
     * Return count of all firstlevel elements.
     *
     * @return int
     */
    public function count();
}
