<?php
declare(strict_types=1);

namespace Asm\Tests\Value\Scalar;

use Asm\Exception\InvalidBooleanException;
use Asm\Value\Scalar\BoolValue;
use Asm\Value\ValueInterface;

/**
 * Class BoolValueTest
 *
 * @package Asm\Tests\Value\Scalar
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class BoolValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $value = new BoolValue(true);
        $this->assertInstanceOf(ValueInterface::class, $value);
        $this->assertTrue($value->value());
        $value = new BoolValue(false);
        $this->assertFalse($value->value());
    }

    public function testExceptionOnInvalidValue()
    {
        $this->expectException(InvalidBooleanException::class);
        $value = new BoolValue('I am not a bool!');
    }
}
