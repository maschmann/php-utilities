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
 * Class DataCollection
 *
 * @package Asm\Data
 * @author marc aschmann <maschmann@gmail.com>
 */
class DataCollection extends Data implements DataInterface, \Iterator
{

    /**
     * @var integer
     */
    protected $position;

    /**
     * @var integer
     */
    protected $totalCount = 0;

    /**
     * @param array $data
     */
    public function __construct($data = null)
    {
        if (null != $data && is_array($data)) {
            $this->set('items', $data);
        }

        $this->position = 0;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->get('items', $this->position);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     *                 Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->get('items', $this->position, false);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * add element to store
     *
     * @param  mixed   $item
     * @param  integer $position
     * @return $this
     */
    public function addItem($item, $position = null)
    {
        if (null == $position) {
            $items = $this->get('items', array());
            array_push($items, $item);
            $this->set('items', $items);
        } else {
            $this->set('items', $position, $item);
        }

        return $this;
    }

    /**
     * get element from store
     *
     * @param  int        $position
     * @return bool|mixed
     */
    public function getItem($position = 0)
    {
        return $this->get('items', $position, false);
    }

    /**
     * @return integer
     */
    public function count()
    {
        return count($this->get('items', array()));
    }

    /**
     * remove item from position
     * be carefull: this also reindexes the array
     *
     * @param  integer $position
     * @return $this
     */
    public function removeItem($position)
    {
        $items = $this->get('items', array());

        if (isset($items[$position])) {
            unset($items[$position]);
            $this->set('items', null);
            $this->set('items', array_values($items));
        }

        return $this;
    }
}
