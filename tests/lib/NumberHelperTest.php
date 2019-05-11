<?php

namespace Gomobile\SDK\Tests\lib;

use PHPUnit\Framework\TestCase;
use Gomobile\SDK\HLP\NumberHelper;

class NumberHelperTest extends TestCase {

    public function testIsValidInternationalNumber () {
        $this->assertTrue(NumberHelper::isValidInternationalNumber("+212707071290"));
    }

    public function testIsValidNationalNumber () {
        $this->assertTrue(NumberHelper::isValidNationalNumber("0707071290"));
    }

    public function testPhoneConverter() {
        $this->assertEquals(NumberHelper::phoneConverter("+212707071290"), "0707071290");
    }

    public function testIsValidArrayPhoneNumbers () {
        $goodPhones = array("0707071290", "0601056593");
        $this->assertTrue(NumberHelper::isValidArrayPhoneNumbers($goodPhones));
    }
}