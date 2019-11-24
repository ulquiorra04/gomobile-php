<?php

namespace Gomobile\SDK;

use Gomobile\SDK\HLP\NumberHelper;
use Gomobile\SDK\HLP\ParameterHelper;

class Call extends Base {
    
    /**
     * Make single Static Call
     * @param string $phoneNumber
     * @param int $scenarioId
     * @param string $callBack
     * 
     * @return json
     */
    public function makeSingleStaticCall ($phoneNumber, $scenarioId, $callBack, $requireValidation=0) {

        // Check if valid number
        if(!NumberHelper::isValidNationalNumber($phoneNumber))
            return $this->error('You must use a valid moroccan phone number');
        
        $url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        $url .= parent::SINGLE_STATIC_CALL;
        $response = $this->client->request('POST', $url, [
                        'form_params' => [
                            'login' => $this->username,
                            'password' => $this->password,
                            'scenarioId' => $scenarioId,
                            'callBack' => $callBack,
                            'requireValidation' => $requireValidation,
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
    public function makeMultipleStaticCall ($phonesNumber, $scenarioId, $callBack, $requireValidation=0) {
        // Check if the numbers are array 
        if(!is_array($phonesNumber))
            return $this->error("You must send an array of phone numbers");

        if(!NumberHelper::isValidArrayPhoneNumbers($phonesNumber))
            return $this->error("You have to provide a valid phone numbers");
        
        $tableNumber = [];
        foreach ($phonesNumber as $phone) {
            array_push($tableNumber, ["phoneNumber" => $phone]);
            //$tableNumber["phoneNumber"] = $phone;
        }
        
        $url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        $url .= parent::MULTIPLE_STATIC_CALL;
        $response = $this->client->request('POST', $url, [
                        'form_params' => [
                            'login' => $this->username,
                            'password' => $this->password,
                            'scenarioId' => $scenarioId,
                            'callBack' => $callBack,
                            'requireValidation' => $requireValidation,
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
     * @param int $scenarioId
     * @param Array $data
     *
     * @return json
     */
    public function makeSingleDynamicCall ($phoneNumber, $scenarioId, $callBack, $data=array(), $requireValidation=0) {
        
        if(!NumberHelper::isValidNationalNumber($phoneNumber))
            return $this->error("The phone number is not valid");
        if(!is_array($data))
            return $this->error("You must send an array of data");

        //Check the parameters send
        $requestParameters = ParameterHelper::prepareParameters($data);
        if(empty($requestParameters))
            return $this->error("You must send one of these parameters : user_amount, date, user_agent");
        $requestParameters["phoneNumber"] = $phoneNumber;

        $url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        $url .= parent::SINGLE_DYNAMIC_CALL;
        $response = $this->client->request('POST', $url, [
                        'form_params' => [
                            'login' => $this->username,
                            'password' => $this->password,
                            'scenarioId' => $scenarioId,
                            'callBack' => $callBack,
                            'requireValidation' => $requireValidation,
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
     * @param array $PhonesNumber ["phone" => "0707071290", "user_amount" => 300]
     * @param int $scenarioId
     * @param string $callBack
     * 
     * @return json
     */
    public function makeMultipleDynamicCall ($phonesNumber, $scenarioId, $callBack, $requireValidation=0) {

        $apiPhoneAarray = [];
        // Check if the numbers are array 
        if(!is_array($phonesNumber))
            return $this->error("You must send an array of phone numbers");
        
        //Check the parameters send
        foreach ($phonesNumber as $phone) {
            // Check if the phone number is valid
            if(!NumberHelper::isValidNationalNumber($phone["phone"]))
                return $this->error("The phone number is not valid");
            
            // Check data send with phone number
            $requestParameters = ParameterHelper::prepareParameters($phone);
            if(empty($requestParameters))
                return $this->error("You must send one of these parameters : user_amount, date, user_agent");
            $requestParameters["phoneNumber"] = $phone["phone"];

            array_push($apiPhoneAarray, $requestParameters);
        }
        
        $url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        $url .= parent::MULTIPLE_DYNAMIC_CALL;

        $response = $this->client->request('POST', $url, [
            'form_params' => [
                'login' => $this->username,
                'password' => $this->password,
                'scenarioId' => $scenarioId,
                'callBack' => $callBack,
                'requireValidation' => $requireValidation,
                'user' => json_encode($apiPhoneAarray)
            ]
        ]);
        if($response->getStatusCode() == 200) {
            return $this->success($response->getBody()->getContents());
        } else {
            return $this->error("error while processing");
        }
    }

}