<?php
declare(strict_types=1);

namespace Asm\Exception;

/**
 * Class TypeNotFoundException
 *
 * @package Asm\Exception
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class TypeNotFoundException extends \InvalidArgumentException
{
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $message = sprintf('Type for "%s" could not be determined', $value);
        parent::__construct($message);
    }
}