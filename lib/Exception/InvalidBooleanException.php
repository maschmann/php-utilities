<?php
declare(strict_types=1);

namespace Asm\Exception;

/**
 * Class InvalidBooleanException
 *
 * @package Asm\Exception
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class InvalidBooleanException extends \InvalidArgumentException
{
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $message = sprintf('"%s" is not a valid boolean', $value);
        parent::__construct($message);
    }
}