<?php
declare(strict_types=1);

namespace Asm\Tests\Value\Scalar;

use Asm\Exception\InvalidIntegerException;
use Asm\Value\Scalar\IntValue;
use Asm\Value\ValueInterface;

/**
 * Class IntValueTest
 *
 * @package Asm\Tests\Value\Scalar
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class IntValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $value = new IntValue(500);
        $this->assertInstanceOf(ValueInterface::class, $value);
        $this->assertTrue(is_int($value->value()));
        $value = new IntValue(3);
        $this->assertTrue(is_int($value->value()));
    }

    public function testExceptionOnInvalidValue()
    {
        $this->expectException(InvalidIntegerException::class);
        $value = new IntValue(1.0);
    }
}
