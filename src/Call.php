<?php

namespace Gomobile\SDK;

use Gomobile\HLP\NumberHelper;

class Call extends Base {
    
    /**
     * Make a single Static Call
     * @param string $phoneNumber
     * @param int $scenarioId
     * 
     * @return json
     */
    public function makeSingleStaticCall ($phoneNumber, $scenarioId) {

        // Check if valid number
        if(!NumberHelper::isNationnalNumber($phoneNumber))
            return $this->error('You must use a valid moroccan phone number');

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
            return $this->success($response->getBody()->getContents());
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
            return $this->success($response->getBody()->getContents());
        } else {
            return $this->error("error while processing");
        }
    }

    public function makeSingleDynamicCall ($data=array()) {
        if(!is_array($data))
            return $this->error("You must send a table of data");
        $url = parent::BASE_DOMAINE . parent::SINGLE_DYNAMIC_CALL;
        $response = $this->client->request('POST', $url, [
                        'form_params' => [
                            'login' => $this->username,
                            'password' => $this->password,
                            'scenarioId' => $scenarioId,
                            'user' => json_encode($data)
                        ]
                    ]);
        if($response->getStatusCode() == 200) {
            return $this->success($response->getBody()->getContents());
        } else {
            return $this->error("error while processing");
        }
    }

}