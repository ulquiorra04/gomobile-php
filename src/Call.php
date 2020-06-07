<?php

namespace Gomobile\GomobileBundle\src;

use Gomobile\GomobileBundle\lib\NumberHelper;
use Gomobile\GomobileBundle\lib\ParameterHelper;

class Call extends Base {
    private $parameterHelper;

    public function __construct ($client, $username, $password, $demo=false) {
        $this->parameterHelper = new ParameterHelper();
        parent::__construct($client, $username, $password, $demo);
    }

    /**
     * Make single Static Call
     * @param string $phoneNumber
     * @param int $scenarioId
     * @param string $callBack
     *
     * @return json
     */
    public function makeSingleStaticCall ($phoneNumber, $scenarioId) {

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
                            'user' => json_encode(["phoneNumber" => $phoneNumber])
                        ]
                    ]);
        if($response->getStatusCode() == 200) {
            return $this->success("Your calls are in process", $response->getBody()->getContents());
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
                            'user' => json_encode($tableNumber)
                        ]
                    ]);
        if($response->getStatusCode() == 200) {
            return $this->success("Your calls are in process", $response->getBody()->getContents());
        } else {
            return $this->error("error while processing");
        }
    }

    /**
     * Make single dynamic call
     * @param string $phoneNumber
     * @param int $scenarioId
     * @param Array $data [user_amount => 300]
     *
     * @return json
     */
    public function makeSingleDynamicCall ($phoneNumber, $scenarioId, $data=array()) {

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
                            'user' => json_encode($requestParameters)
                        ]
                    ]);
        if($response->getStatusCode() == 200) {
            return $this->success("Your calls are in process", $response->getBody()->getContents());
        } else {
            return $this->error("error while processing");
        }
    }

    /**
     * Make multiple dynamic call
     * @param array $PhonesNumber [{"phoneNumber": "0707071290", "user_amount": 300}, {"phoneNumber": "0707071290", "user_amount": 200}]
     * @param int $scenarioId
     * @param array $options [sda => "05XXXXXXXX"]
     *
     * @return json
     */
    public function makeMultipleDynamicCall ($phonesNumber, $scenarioId, $options) {
        $phonesNumber = json_decode($phonesNumber);

        // Check if we send array of data & is not empty
        if(!is_array($phonesNumber) || empty($phonesNumber))
            return $this->error("Either you provided an empty table or not a table");
        // Check the phone numbers send

        foreach ($phonesNumber as $phoneNumber) {
            if(is_string($phoneNumber))
                $phoneNumber = json_decode($phoneNumber);
            // check if the phone property exists
            if(!property_exists($phoneNumber, "phoneNumber")){
                return $this->error("Please provide a phoneNumber property for the object");
            }elseif(!NumberHelper::isValidNationalNumber($phoneNumber->phoneNumber)){
                // Check if the phone is in correct format
                return $this->error("incorrect format for phone number $phoneNumber->phoneNumber");
            }
            // check if the parameters are supported
            if(!$this->parameterHelper->isSupportedParameters($phoneNumber))
                return $this->error("You have send a non supported parameter");
            //return $this->success("data correct", $phoneNumber);
        }

        // Prepare to make the call
        $url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        $url .= parent::MULTIPLE_DYNAMIC_CALL;
        $params = [
            'login' => $this->username,
            'password' => $this->password,
            'scenarioId' => $scenarioId,
            'user' => json_encode($phonesNumber)
        ];
        if(isset($options['sda']))
            array_push($params, $options['sda']);
        if(isset($options['call_date_time']))
            array_push($params, $options['call_date_time']);
        $response = $this->client->request('POST', $url, ['form_params' => $params]);

        if($response->getStatusCode() == 200)
            return $this->success("Your calls are in process", $response->getBody()->getContents());
        else
            return $this->error("error while processing");
    }

}
