<?php
declare(strict_types=1);

namespace Asm\Value;

/**
 * Value object base implementation
 *
 * @package Asm\Value
 * @author Marc Aschmann <maschmann@gmail.com>
 */
abstract class AbstractBaseValue implements ValueInterface
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * AbstractValue constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        if (false === $this->isNullable($value)) {
            $this->protect($value);
        }

        $this->value = $value;
    }

    /**
     * Do checks based on the type of value.
     *
     * @param mixed $value
     */
    abstract protected function protect($value);

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Check if we're allowed to be null.
     *
     * @param mixed $value
     * @return bool
     */
    protected function isNullable($value): bool
    {
        return is_null($value) && $this instanceof NullableInterface;
    }
}
