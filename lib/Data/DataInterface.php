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

use Asm\Exception\InvalidParameterException;
use Asm\Exception\InvalidParameterSetException;

/**
 * Interface DataInterface
 *
 * @package Asm\Data
 * @author Marc Aschmann <maschmann@gmail.com>
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
     * @throws InvalidParameterSetException
     * @return $this
     */
    public function set();

    /**
     * Set list of key/value pairs via one dimensional array.
     * Careful: An empty array will just overwrite your internal storage.
     *
     * @param  array $param
     * @return $this
     */
    public function setByArray(array $param);

    /**
     * Adds given object's properties to interal array or migrates
     * another DataInterface object's contents to current object.
     *
     * @param  object $param
     * @return $this
     * @throws InvalidParameterException
     */
    public function setByObject($param);

    /**
     * Fill datastore by json string.
     *
     * @param string $json
     * @return $this
     */
    public function setByJson(string $json);

    /**
     * Return stored data array.
     *
     * @return array
     */
    public function toArray() : array;

    /**
     * Convert internal data to json.
     *
     * @return string
     */
    public function toJson() : string;

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
    public function remove(string $key);

    /**
     * Get all firstlevel keys of interal array.
     *
     * @return array
     */
    public function getKeys() : array;

    /**
     * Return count of all firstlevel elements.
     *
     * @return int
     */
    public function count() : int;

    /**
     * Find a key in an array.
     * example self::findInArray(array(), key1, key2, key3, ..., default_return)
     *
     * @return array|bool|mixed
     */
    public static function findInArray();
}
