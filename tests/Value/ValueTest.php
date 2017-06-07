<?php
declare(strict_types=1);

namespace Asm\Tests\Value;

use Asm\Value\Scalar\BoolValue;
use Asm\Value\Scalar\FloatValue;
use Asm\Value\Scalar\IntValue;
use Asm\Value\Scalar\StringValue;
use Asm\Value\Value;

/**
 * Class ValueTest
 *
 * @package Asm\Tests\Value
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class ValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateString()
    {
        $value = Value::build('some string');
        $this->assertInstanceOf(StringValue::class, $value);
        $this->assertTrue(is_string($value->value()));
    }

    public function testCreateIntValue()
    {
        $value = Value::build(5);
        $this->assertInstanceOf(IntValue::class, $value);
        $this->assertTrue(is_int($value->value()));
    }

    public function testCreateFloatValue()
    {
        $value = Value::build(1.356);
        $this->assertInstanceOf(FloatValue::class, $value);
        $this->assertTrue(is_float($value->value()));
    }

    /*public function testCreateNaturalNumber()
    {
        $value = Value::build();
        $this->assertInstanceOf(NaturalNumberValue::class, $value);
    }*/

    public function testCreateBoolValue()
    {
        $value = Value::build(true);
        $this->assertInstanceOf(BoolValue::class, $value);
        $this->assertTrue(is_bool($value->value()));
    }
}
