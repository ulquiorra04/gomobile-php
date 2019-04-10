<?php

namespace Gomobile\SDK;

class Base {

    protected $client;
    protected $username;
    protected $password;

    const BASE_DOMAINE = "http://192.168.1.6/";
    const SINGLE_STATIC_CALL = "backoffice/ScenariosUsers/makeSingleStaticCall";
    const MULTIPLE_STATIC_CALL = "backoffice/ScenariosUsers/makeMultipleStaticCall";
    
    public function __construct ($client, $username, $password) {
        $this->client = $client;
        $this->username = $username;
        $this->password = $password;
    }

    public function error ($data) {
        return [
            'status' => 'error',
            'message' => $data
        ];
    }

    public function success ($data) {
        return [
            'status' => 'success',
            'message' => $data
        ];
    }

}