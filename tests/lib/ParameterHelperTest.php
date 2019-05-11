<?php

namespace Gomobile\SDK\Tests\lib;

use PHPUnit\Framework\TestCase;
use Gomobile\SDK\HLP\ParameterHelper;

class ParameterHelperTest extends TestCase {

	public function testPrepareParameters () {
		$data = ["user_amount" => 2000];
		$this->assertArrayHasKey("user_amount", $data);
	}

}