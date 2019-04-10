<?php

namespace Gomobile\SDK;

class Call extends Base {
    
    public function makeSingleStaticCall ($phoneNumber, $scenarioId) {
        $url = parent::BASE_DOMAINE . parent::SINGLE_STATIC_CALL;
        $response = $this->client->request('POST', $url, [
                        'form_params' => [
                            'login' => $this->username,
                            'password' => $this->password,
                            'scenarioId' => $scenarioId,
                            'user' => json_encode(["phoneNumber" => $phoneNumber])
                        ]
                    ]);
        if($response->getStatusCode() == 200) {
            return $this->success($response->getBody());
        } else {
            return $this->error("error while processing");
        }
    }

    public function makeMultipleStaticCall ($phonesNumber, $scenarioId) {
        if(!is_array($phoneNumber))
            return $this->error("You must send a table of phone numbers");
        $tableNumber = [];
        foreach ($phonesNumber as $phone) {
            array_push($tableNumber, ["phoneNumber" => $phone]);
        }
        
        $url = parent::BASE_DOMAINE . parent::MULTIPLE_STATIC_CALL;
        $response = $this->client->request('POST', $url, [
                        'form_params' => [
                            'login' => $this->username,
                            'password' => $this->password,
                            'scenarioId' => $scenarioId,
                            'user' => json_encode($tableNumber)
                        ]
                    ]);
        if($response->getStatusCode() == 200) {
            return $this->success($response->getBody());
        } else {
            return $this->error("error while processing");
        }
    }

}