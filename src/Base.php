<?php

namespace Gomobile\SDK;

class Base {

    protected $client;
    protected $username;
    protected $password;
    protected $demo;

    const BASE_LOCAL_DOMAINE = "http://192.168.1.6/";
    const BASE_GLOBAL_DOMAINE = "http://197.230.235.108/";
    const SINGLE_STATIC_CALL = "backoffice/ScenariosUsers/makeSingleStaticCall";
    const MULTIPLE_STATIC_CALL = "backoffice/ScenariosUsers/makeMultipleStaticCall";
    const SINGLE_DYNAMIC_CALL = "backoffice/ScenariosUsers/makeSingleDynamicCall";
    const MULTIPLE_DYNAMIC_CALL = "";
    
    public function __construct ($client, $username, $password, $demo=false) {
        $this->client = $client;
        $this->username = $username;
        $this->password = $password;
        $this->demo = $demo;
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