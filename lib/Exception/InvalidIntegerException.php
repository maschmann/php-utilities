<?php
declare(strict_types=1);

namespace Asm\Exception;

/**
 * Class InvalidStringException
 *
 * @package Asm\Exception
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class InvalidIntegerException extends \InvalidArgumentException
{
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $message = sprintf('"%s" is not a valid integer', $value);
        parent::__construct($message);
    }
}