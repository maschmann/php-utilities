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
 * data container base
 *
 * @author Marc Aschmann <maschmann@gmail.com>
 * @package Asm\Data
 */
class DataContainer extends Data implements DataInterface
{

    /**
     * magic caller
     *
     * @param  string $methodName
     * @param  array $args
     * @throws \InvalidArgumentException
     * @return bool|mixed
     */
    public function __call($methodName, $args)
    {
        // prepare key for array storage search
        $strTmpKey = $this->normalizeGetSetKey($methodName);
        $mixRetVal = null;

        switch (true) {
            case (0 === strpos($methodName, 'get')):
                return $this->getKey($strTmpKey);
                break;
            case (0 === strpos($methodName, 'set')):
                return $this->setKey($strTmpKey, $args[0]);
                break;
            default:
                throw new \InvalidArgumentException(
                    '--  ( ' . __FILE__ . ' ) ( ' . __LINE__ . ' ) -- Method ' .
                    $methodName . ' does not exist: only get/set is allowed! ' . get_called_class()
                );
                break;
        }

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
                $key = $this->normalizeKey($key);
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
     * @param  array                     $param
     * @return $this|void
     * @throws \InvalidArgumentException
     */
    public function setByArray(array $param)
    {
        if (0 < count($param)) {
            // reset array to explicitly start at beginning
            reset($param);
            foreach ($param as $key => $value) {
                $this->setKey($key, $value);
            }
        } else {
            throw new \InvalidArgumentException('--  ( ' . __FILE__ . ' ) ( ' . __LINE__ . ' ) -- param is empty!');
        }
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
            $mixLastElm = array_pop($args);
            if (empty($mixLastElm) && !is_numeric($mixLastElm)) {
                $default = $mixLastElm;
            } else {
                // push the last element back into array
                array_push($args, $mixLastElm);
            }
        }

        foreach ($args as $key) {
            $strNormKey = $this->normalizeKey($key);
            if (array_key_exists($key, $data)) {
                $data = $data[$key];
            } elseif (array_key_exists($strNormKey, $data)) {
                $data = $data[$strNormKey];
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
    protected function normalizeKey($key)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
    }

    /**
     * normalize keys for checking
     *
     * @param  string $key
     * @return string
     */
    protected function normalizeGetSetKey($key)
    {
        $key = lcfirst(str_replace('get', '', str_replace('set', '', $this->normalizeKey($key))));

        return $key;
    }

    /**
     * normalize array structure's keys to lower camel case
     *
     * @param  array        $arrData
     * @return array|string
     */
    public function normalizeArray(array $arrData)
    {
        /**
         * normalizer routine
         *
         * @param array $arrData
         * @param callable $normalizeArray
         * @return array
         */
        $normalizeArray = function ($arrData, $normalizeArray) {
            $arrReturnData = array();

            foreach ($arrData as $key => $val) {

                if (is_array($val)) {
                    $val = $normalizeArray($val, $normalizeArray);
                }

                $arrReturnData[lcfirst(
                    str_replace(' ', '', ucwords(str_replace('_', ' ', $key)))
                )] = $val;
            }

            return $arrReturnData;
        };

        return $normalizeArray($arrData, $normalizeArray);
    }
}
