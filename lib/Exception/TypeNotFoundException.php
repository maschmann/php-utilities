<?php
declare(strict_types=1);
/*
 * This file is part of the asm/php-utilities package.
 *
 * (c) Marc Aschmann <maschmann@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
