<?php

namespace Gomobile\SDK;

use GuzzleHttp\Client;

class Gomobile {

    protected $username;
    protected $password;
    protected $client;

    public function __construct ($username, $password) {
        $this->username = $username;
        $this->password = $password;
        $this->client = new Client();
    }

    public function call () {
        $call = new Call($this->client);
        return $call;
    }

}