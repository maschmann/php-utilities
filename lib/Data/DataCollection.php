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
 * @author Marc Aschmann <maschmann@gmail.com>
 */
final class DataCollection implements DataCollectionInterface
{
    use DataTrait;

    const STORAGE_KEY = 'items';

    /**
     * @var int
     */
    private $position;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (null !== $data && is_array($data)) {
            $this->set(self::STORAGE_KEY, $data);
        }

        $this->position = 0;
    }

    /**
     * (PHP 5 >= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->get(self::STORAGE_KEY, $this->position);
    }

    /**
     * (PHP 5 >= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * (PHP 5 >= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return int scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * (PHP 5 >= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return bool The return value will be casted to bool and then evaluated.
     *                 Returns true on success or false on failure.
     */
    public function valid() : bool
    {
        return (bool)$this->get(self::STORAGE_KEY, $this->position, false);
    }

    /**
     * (PHP 5 >= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Add element to store.
     *
     * @param  mixed $item
     * @param  int $position
     * @return $this
     */
    public function addItem($item, $position = null)
    {
        if (null === $position) {
            $items = $this->get(self::STORAGE_KEY, []);
            array_push($items, $item);
            $this->set(self::STORAGE_KEY, $items);
        } else {
            $this->set(self::STORAGE_KEY, $position, $item);
        }

        return $this;
    }

    /**
     * Get element from store.
     *
     * @param  int $position
     * @return bool|mixed
     */
    public function getItem(int $position = 0)
    {
        return $this->get(self::STORAGE_KEY, $position, false);
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return count($this->get(self::STORAGE_KEY, []));
    }

    /**
     * remove item from position
     * be carefull: this also reindexes the array
     *
     * @param  int $position
     * @return $this
     */
    public function removeItem(int $position)
    {
        $items = $this->get(self::STORAGE_KEY, []);

        if (isset($items[$position])) {
            unset($items[$position]);
            $this->set(self::STORAGE_KEY, null);
            $this->set(self::STORAGE_KEY, array_values($items));
        }

        return $this;
    }
}
