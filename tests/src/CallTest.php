<?php

namespace Gomobile\GomobileBundle\Test\src;

use PHPUnit\Framework\TestCase;
use Gomobile\GomobileBundle\src\Gomobile;

class CallTest extends TestCase {
    public function testMakeMultipleDynamicCall () {
        $gomobile = new Gomobile("demo", "demo", true);
        $call = $gomobile->call();
        $data = json_encode([["phone" => "0707071290"], ["phone" => "0707070136"]]);
        //var_dump($data); die();
        $result = $call->makeMultipleDynamicCall($data, 1, []);
        var_dump($result);
        $this->assertEquals($result['status'], 0);
    }
}
