<?php

namespace Gomobile\SDK;

use Gomobile\HLP\NumberHelper;
use Gomobile\HLP\ParameterHelper;

class Call extends Base {
    
    /**
     * Make single Static Call
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

    /**
     * Make multiple static call
     * @param Array $phonesNumber
     * @param int $scenarioId
     *
     * @return json
     */
    public function makeMultipleStaticCall ($phonesNumber, $scenarioId) {
        // Check if the numbers are array 
        if(!is_array($phoneNumber))
            return $this->error("You must send an array of phone numbers");

        if(!NumberHelper::isValidArrayPhoneNumbers($phonesNumber))
            return $this->error("You have to provide a valid phone numbers");
        
        $tableNumber = [];
        foreach ($phonesNumber as $phone) {
            $tableNumber["phoneNumber"] = $phone;
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

    /**
     * Make single dynamic call
     * @param string $phoneNumber
     * @param Array $data
     *
     * @return json
     */
    public function makeSingleDynamicCall ($phoneNumber, $data=array()) {
        
        if(NumberHelper::isValidNationalNumber($phoneNumber))
            return $this->error("The phone number is not valid");
        if(!is_array($data))
            return $this->error("You must send an array of data");

        //Check the parameters send
        $requestParameters = ParameterHelper::prepareParameters($data);
        if(empty($requestParameters))
            return $this->error("You must send one of these parameters : user_amount, date, user_agent");
        $requestParameters["phoneNumber"] = $phoneNumber;

        $url = parent::BASE_DOMAINE . parent::SINGLE_DYNAMIC_CALL;
        $response = $this->client->request('POST', $url, [
                        'form_params' => [
                            'login' => $this->username,
                            'password' => $this->password,
                            'scenarioId' => $scenarioId,
                            'user' => json_encode($requestParameters)
                        ]
                    ]);
        if($response->getStatusCode() == 200) {
            return $this->success($response->getBody()->getContents());
        } else {
            return $this->error("error while processing");
        }
    }

    /**
     * Make multiple dynamic call
     * @param array $parameters
     *
     * @return json
     */
    public function makeMultipleDynamicCall ($data) {
        if(!is_array($data))
            return $this->error("You must send an array of data");
    }
}