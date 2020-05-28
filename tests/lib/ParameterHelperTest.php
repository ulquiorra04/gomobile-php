<?php

namespace Gomobile\SDK\Tests\lib;

use PHPUnit\Framework\TestCase;
use Gomobile\GomobileBundle\lib\ParameterHelper;

class ParameterHelperTest extends TestCase {

	public function testPrepareParameters () {
		$data = ["user_amount" => 2000];
		$this->assertArrayHasKey("user_amount", $data);
	}

	public function testReturnTypeOfConvertObjectPropertyToArray () {
		// Check type of return

		$obj = json_decode('{"name": "abdelhamid", "age": 29 }');
		$result = ParameterHelper::convertObjectPropertyToArray($obj);

		$this->assertIsArray($result);
	}

	public function testIsSupportedParameters ()
	{
		$p = new ParameterHelper();
		$obj = json_decode('{"phone": "0707071290", "source": "AGENT_X" }');

		$isSupported = $p->isSupportedParameters($obj);
		$this->assertTrue($isSupported);
	}

}
