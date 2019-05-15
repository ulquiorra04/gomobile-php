<?php

namespace Gomobile\SDK;

use GuzzleHttp\Client;

class Gomobile {

    protected $username;
    protected $password;
    protected $client;
    protected $demo;

    public function __construct ($username, $password, $demo = false) {
        $this->username = $username;
        $this->password = $password;
        $this->demo = $demo;
        $this->client = new Client();
    }

    public function call () {
        $call = new Call($this->client, $this->username, $this->password, $this->demo);
        return $call;
    }

    public function scenario () {
        $scenario = new Scenario ($this->client, $this->username, $this->password, $this->demo);
        return $scenario;
    }

}