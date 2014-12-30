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
     * remove all data from object
     */
    public function clear();

    /**
     * generic set method for multidimensional storage
     * $this->set( $key1, $key2, $key3, ..., $mixVal )
     *
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function set();

    /**
     * set list of key/value pairs via one dimensional array
     *
     * @param  array                     $param
     * @throws \InvalidArgumentException
     */
    public function setByArray(array $param);

    /**
     * adds given object's properties to self
     *
     * @param  object                    $param
     * @throws \InvalidArgumentException
     */
    public function setByObject($param);

    /**
     * fill datastore by json string
     *
     * @param string $json
     * @return mixed
     */
    public function setByJson($json);

    /**
     * multidimensional getter
     * find a key structure in a multidimensional array and return the value
     * params are stackable -> get( $k1, $k2, $k3, ... )
     *
     * @return bool|mixed
     */
    public function get();

    /**
     * remove key from container
     *
     * @param string $key
     */
    public function remove($key);

    /**
     * gets key index
     *
     * @return array keylist
     */
    public function getKeys();

    /**
     * return count of all firstlevel elements
     *
     * @return int
     */
    public function count();
}
