<?php
declare(strict_types=1);

namespace Asm\Exception;

/**
 * Class InvalidNaturalNumberException
 *
 * @package Asm\Exception
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class InvalidNaturalNumberException extends \InvalidArgumentException
{
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $message = sprintf('"%s" is not a valid natural number', $value);
        parent::__construct($message);
    }
}