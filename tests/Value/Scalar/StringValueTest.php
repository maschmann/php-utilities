<?php
declare(strict_types=1);

namespace Asm\Tests\Value\Scalar;

use Asm\Exception\InvalidStringException;
use Asm\Value\Scalar\StringValue;
use Asm\Value\ValueInterface;

/**
 * Class StringValueTest
 *
 * @package Asm\Tests\Value\Scalar
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class StringValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $value = new StringValue('');
        $this->assertInstanceOf(ValueInterface::class, $value);
        $value = new StringValue('some longer string');
        $this->assertInstanceOf(ValueInterface::class, $value);
        $value = new StringValue((string)2500); // HaHaHaHaHaHa :-D :-D :-D
        $this->assertInstanceOf(ValueInterface::class, $value);
    }

    public function testExceptionOnInvalidValue()
    {
        $this->expectException(InvalidStringException::class);
        $value = new StringValue(-5);
    }
}
