<?php
declare(strict_types=1);

namespace Asm\Tests\Value\Scalar;

use Asm\Exception\InvalidNaturalNumberException;
use Asm\Value\Scalar\NaturalNumberValue;
use Asm\Value\ValueInterface;

/**
 * Class NaturalNumberValueTest
 *
 * @package Asm\Tests\Value\Scalar
 * @author Marc Aschmann <maschmann@gmail.com>
 */
class NaturalNumberValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $value = new NaturalNumberValue(1);
        $this->assertInstanceOf(ValueInterface::class, $value);
        $value = new NaturalNumberValue(1.356);
        $this->assertInstanceOf(ValueInterface::class, $value);
    }

    public function testExceptionOnInvalidValue()
    {
        $this->expectException(InvalidNaturalNumberException::class);
        $value = new NaturalNumberValue(-5);
    }
}
