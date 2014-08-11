<?php
/**
 * @namespace Asm\Data
 */
namespace Asm\Data;

/**
 * Class Data
 *
 * @package Asm\Data
 * @author marc aschmann <maschmann@gmail.com>
 */
class Data implements DataInterface
{

    /**
     * internal data storage
     *
     * @var array
     */
    protected $data = array();

    /**
     * clears the data(!) content of the object
     */
    public function clear()
    {
        $this->data = array();
    }

    /**
     * generic set method for multidimensional storage
     * $this->setKey( $key1, $key2, $key3, ..., $val )
     *
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function setKey()
    {
        $args = func_get_args();
        $replace = null;

        if (1 < count($args)) {
            // get last array element == value to set!
            $val = array_pop($args);

            // iterate arguments reversed to build replacement array
            foreach (array_reverse($args) as $key) {
                if (null == $replace) {
                    $replace = array($key => $val);
                } else {
                    $replace = array($key => $replace);
                }
            }

            // add our data to storage
            $this->data = array_replace_recursive($this->data, $replace);
        } else {
            throw new \InvalidArgumentException(
                '--  ( ' . __FILE__ . ' ) ( ' . __LINE__ . ' ) -- Not enough Parameters, need at least key + val'
            );
        }

        return $this;
    }

    /**
     * set list of key/value pairs via one dimensional array
     *
     * @param  array $param
     * @return $this
     */
    public function setByArray(array $param)
    {
        // reset array to explicitly start at beginning
        reset($param);
        foreach ($param as $key => $value) {
            $this->setKey($key, $value);
        }

        return $this;
    }

    /**
     * adds given object's properties to self
     *
     * @param  object                    $param
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setByObject($param)
    {
        // check for DataContainer instances - because otherwise you can't easily access virtual properties
        if (is_object($param)) {
            if (is_a($param, 'Asm\Data\DataContainer', true)) {
                foreach ($param->getAllData() as $key => $value) {
                    $this->setKey($key, $value);
                }
            } else {
                // handle as "normal" object
                foreach ($param as $property => $value) {
                    $this->setKey($property, $value);
                }
            }
        } else {
            throw new \InvalidArgumentException('--  ( ' . __FILE__ . ' ) ( ' . __LINE__ . ' ) -- param is no object!');
        }

        return $this;
    }

    /**
     * fill datastore from json string
     *
     * @param string $json
     * @return $this|mixed
     */
    public function setByJson($json)
    {
        $this->setByArray(
            json_decode($json, true)
        );

        return $this;
    }

    /**
     * multidimensional getter
     * find a key structure in a multidimensional array and return the value
     * params are stackable -> getKey( $k1, $k2, $k3, ... )
     *
     * @return bool|mixed
     */
    public function getKey()
    {
        $data = $this->data;
        $default = false;
        $args = func_get_args();

        // check for default return value
        if (1 < count($args)) {
            $lastElm = array_pop($args);
            if (empty($lastElm) && !is_numeric($lastElm)) {
                $default = $lastElm;
            } else {
                // push the last element back into array
                array_push($args, $lastElm);
            }
        }

        foreach ($args as $key) {
            if (array_key_exists($key, $data)) {
                $data = $data[$key];
            } else {
                return $default;
            }
        }

        return $data;
    }

    /**
     * gets key index
     *
     * @return array keylist
     */
    public function getKeys()
    {
        return array_keys($this->data);
    }

    /**
     * remove key from container
     *
     * @param  string $key
     * @return $this
     */
    public function removeKey($key)
    {
        if (array_key_exists($key, $this->data)) {
            unset($this->data[$key]);
        }

        return $this;
    }

    /**
     * return all data from storage
     * @deprecated
     * @return array
     */
    public function getAllData()
    {
        return $this->data;
    }

    /**
     * return stored data array, alias for toArray
     *
     * @return array
     */
    public function getAsArray()
    {
        return $this->toArray();
    }

    /**
     * return stored data array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->data);
    }

    /**
     * return count of all firstlevel elements
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * @return array|bool|mixed
     */
    public static function findInArray()
    {
        $data = array();
        $default = false;
        $args = func_get_args();

        // check for default return value
        if (2 < count($args)) {
            $data = array_shift($args);
            $lastElm = array_pop($args);
            if (empty($lastElm) && !is_numeric($lastElm)) {
                $default = $lastElm;
            } else {
                // push the last element back into array
                array_push($args, $lastElm);
            }
        }

        foreach ($args as $key) {
            if (array_key_exists($key, $data)) {
                $data = $data[$key];
            } else {
                return $default;
            }
        }

        return $data;
    }

    /**
     * normalize a key
     *
     * @param  string $key
     * @return string
     */
    public static function normalize($key)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
    }
}
