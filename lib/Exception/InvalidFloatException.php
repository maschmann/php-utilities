<?php
declare(strict_types=1);

namespace Asm\Exception;

/**
 * Class InvalidFloatException
 *
 * @package Asm\Exception
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class InvalidFloatException extends \InvalidArgumentException
{
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $message = sprintf('"%s" is not a valid float number', $value);
        parent::__construct($message);
    }
}