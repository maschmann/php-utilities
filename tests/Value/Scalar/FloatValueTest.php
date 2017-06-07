<?php
declare(strict_types=1);

namespace Asm\Tests\Value\Scalar;

use Asm\Exception\InvalidFloatException;
use Asm\Value\Scalar\FloatValue;
use Asm\Value\ValueInterface;

/**
 * Class FloatValueTest
 *
 * @package Asm\Tests\Value\Scalar
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class FloatValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $value = new FloatValue(1.35);
        $this->assertInstanceOf(ValueInterface::class, $value);
        $this->assertTrue(is_float($value->value()));
    }

    public function testExceptionOnStringValue()
    {
        $this->expectException(InvalidFloatException::class);
        $value = new FloatValue('I am not a float!');
    }

    public function testExceptionOnIntegerValue()
    {
        $this->expectException(InvalidFloatException::class);
        $value = new FloatValue(1);
    }
}
