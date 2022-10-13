<?php

namespace Gomobile\GomobileBundle\src;

use Gomobile\GomobileBundle\lib\NumberHelper;
use Gomobile\GomobileBundle\lib\ParameterHelper;

class Call extends Base {

    private $parameterHelper;
    private $url;

    public function __construct ($client, $username, $password, $demo=false) {
        $this->parameterHelper = new ParameterHelper();
        $this->url = ($demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        parent::__construct($client, $username, $password, $demo);
    }

    /**
     * Make single Static Call
     * @param string $phoneNumber "0707071290"
     * @param string $tokenMatcher "XXXXXXXXX"
     * @param int $scenarioId XXXX
     * @param array $options ["sda" => "05XXXXXXXX", "call_date_time" => "XXXXXXXXXX", "campaignName" => "XXXXXXXXXXXX"]
     *
     * @return json
     */
    public function makeSingleStaticCall ($phoneNumber, $tokenMatcher, $scenarioId, $options = array()) {

        // Check if valid number
        if(!NumberHelper::isValidNationalNumber($phoneNumber))
            return $this->error('You must use a valid moroccan phone number');

        $this->url .= parent::SINGLE_STATIC_CALL;
        $params = [
            'login' => $this->username,
            'password' => $this->password,
            'scenarioId' => $scenarioId,
            'user' => json_encode(["phoneNumber" => $phoneNumber, "tokenMatcher" => $tokenMatcher])
        ];

        if(isset($options['sda']))
            $params["sda"] = $options['sda'];
        if(isset($options['call_date_time']))
            $params["callDateTime"] = $options['call_date_time'];
        if(isset($options['campaign_name']))
            $params["campaignName"] = $options['campaign_name'];

        $response = $this->client->request('POST', $this->url, ['form_params' => $params]);
        if($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if($result->status == 1)
                return $this->success($result->message, $result->data);
            else
                return $this->error($result->message);
        } else {
            return $this->error("error while processing");
        }
    }

    /**
     * Make multiple static call
     * @param Array $phonesNumber [{"phoneNumber": "0707071290", "tokenMatcher": "XXXXXXXXXXXXX"}, {"phoneNumber": "0707071290", "tokenMatcher": "XXXXXXXXXXXXX"}]
     * @param int $scenarioId
     * @param Array $options
     *
     * @return json
     */
    public function makeMultipleStaticCall ($phonesNumber, $scenarioId, $options) {

        $phonesNumber = json_decode($phonesNumber);

        // Check if the numbers are array
        if(!is_array($phonesNumber) || empty($phonesNumber))
            return $this->error("Either you provided an empty table or not a table");

        if(!NumberHelper::isValidArrayPhoneNumbers($phonesNumber))
            return $this->error("You have to provide a valid phone numbers");

        foreach ($phonesNumber as $phoneNumber) {
            if(is_string($phoneNumber))
                $phoneNumber = json_decode($phoneNumber);

            if(!property_exists($phoneNumber, "phoneNumber"))
                return $this->error("Please provide a phoneNumber property for the object");

            if(!NumberHelper::isValidNationalNumber($phoneNumber->phoneNumber))
                return $this->error("incorrect format for phone number $phoneNumber->phoneNumber");

            if(!$this->parameterHelper->isSupportedParameters($phoneNumber))
                return $this->error("You have send a non supported parameter");
        }

        $params = [
            'login' => $this->username,
            'password' => $this->password,
            'scenarioId' => $scenarioId,
            'users' => json_encode($phonesNumber)
        ];

        if(isset($options['sda']))
            $params["sda"] = $options['sda'];
        if(isset($options['call_date_time']))
            $params["callDateTime"] = $options['call_date_time'];
        if(isset($options['campaign_name']))
            $params["campaignName"] = $options['campaign_name'];

        $this->url .= parent::MULTIPLE_STATIC_CALL;
        $response = $this->client->request('POST', $this->url, ['form_params' => $params]);

        if($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if($result->status == 1)
                return $this->success($result->message, $result->data);
            else
                return $this->error($result->message);
        } else {
            return $this->error("error while processing");
        }
    }

    /**
     * Make single dynamic call
     * @param string $phoneNumber
     * @param string $tokenMatcher
     * @param int $scenarioId
     * @param array $data ["user_amount" => 300, "user_identify" => "XXXXXXXX"]
     * @param array $options ["sda" => "05XXXXXXXX", "call_date_time" => "XXXXXXXXXX", "campaignName" => "XXXXXXXXXXXX"]
     *
     * @return json
     */
    public function makeSingleDynamicCall ($phoneNumber, $tokenMatcher, $scenarioId, $data = [], $options = []) {

        if(!NumberHelper::isValidNationalNumber($phoneNumber))
            return $this->error("The phone number is not valid");
        if(!is_array($data))
            return $this->error("You must send an array of data");

        //Check the parameters send
        $requestParameters = ParameterHelper::prepareParameters($data);
        if(empty($requestParameters))
            return $this->error("You must send one of these parameters : user_amount, date, user_agent");
        $requestParameters["phoneNumber"] = $phoneNumber;

        $this->url .= parent::SINGLE_DYNAMIC_CALL;

        $params = [
            'login' => $this->username,
            'password' => $this->password,
            'scenarioId' => $scenarioId,
            'user' => json_encode($requestParameters)
        ];

        if(isset($options['sda']))
            $params["sda"] = $options['sda'];
        if(isset($options['call_date_time']))
            $params["callDateTime"] = $options['call_date_time'];
        if(isset($options['campaign_name']))
            $params["campaignName"] = $options['campaign_name'];

        $response = $this->client->request('POST', $this->url, ['form_params' => $params]);

        if($response->getStatusCode() == 200) {
            $result = $response->getBody()->getContents();
            if($result->status == 1)
                return $this->success($result->message, $result->data);
            else
                return $this->error($result->message);
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
        $this->url .= parent::MULTIPLE_DYNAMIC_CALL;
        $params = [
            'login' => $this->username,
            'password' => $this->password,
            'scenarioId' => $scenarioId,
            'users' => json_encode($phonesNumber)
        ];

        if(isset($options['sda']))
            $params["sda"] = $options['sda'];
        if(isset($options['call_date_time']))
            $params["callDateTime"] = $options['call_date_time'];
        if(isset($options['campaign_name']))
            $params["campaignName"] = $options['campaign_name'];

        $response = $this->client->request('POST', $this->url, ['form_params' => $params]);

        if($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if($result->status == 1)
                return $this->success($result->message, $result->data);
            else
                return $this->error($result->message);
        } else {
            return $this->error("error while processing");
        }
    }

    /**
     * @param string $phone "0707071290"
     * @param int $scenarioId
     * @param array $options
     *
     * @return array
     */
    public function makeDirectCall ($phone, $scenarioId, $targetPhone, $options = array())
    {
        if(NumberHelper::isValidInternationalNumber($phone))
            $phone = NumberHelper::phoneConverter($phone);

        if(NumberHelper::isValidInternationalNumber($targetPhone))
            $targetPhone = NumberHelper::phoneConverter($targetPhone);

        if(!NumberHelper::isValidNationalNumber($phone) || !NumberHelper::isValidNationalNumber($targetPhone))
            return $this->error("Please Provide a valid phone number");


        $this->url .= Parent::DIRECT_CALL;
        $params = [
            'login' => $this->username,
            'password' => $this->password,
            'scenarioId' => $scenarioId,
            'user' => json_encode(["phoneNumber" => $phone]),
            'target' => json_encode(['targetNumber' => $targetPhone])
        ];

        if(isset($options["sda"]))
            $params["sda"] = $options["sda"];

        $response = $this->client->request('POST', $this->url, ['form_params' => $params]);

        if($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if($result->status == 1)
                return $this->success($result->message, $result->data);
            else
                return $this->error($result->message);
        } else {
            return $this->error("error while processing");
        }
    }

    /**
     * @param $phones [{"phoneNumber": "0707071290"}, {"phoneNumber": "0707070136"}]
     * @param $scenarioId
     * @param array $options
     * @return array
     */
    public function postMultipleSimpleCall ($phones, $scenarioId, $options=[])
    {
        $phones = json_decode($phones);
        $phones_osix = [];
        if(!is_array($phones) || empty($phones))
            return $this->error("You have to send an array of phone numbers");

        if(!NumberHelper::isValidArrayPhoneNumbers($phones))
            return $this->error("You have to provide a valid phone numbers");

        foreach ($phones as $phoneNumber) {
            if(is_string($phoneNumber))
                $phoneNumber = json_decode($phoneNumber);

            if(!property_exists($phoneNumber, "phoneNumber"))
                return $this->error("Please provide a phoneNumber property for the object");

            if(!NumberHelper::isValidNationalNumber($phoneNumber->phoneNumber))
                return $this->error("incorrect format for phone number $phoneNumber->phoneNumber");


            array_push($phones_osix, ["phone" => $phoneNumber->phoneNumber]);
        }

        $params = [
            'login' => $this->username,
            'password' => $this->password,
            'scenarioId' => $scenarioId,
            'users' => json_encode($phones_osix)
        ];

        if(isset($options['sda']))
            $params["sda"] = $options['sda'];
        if(isset($options['call_date_time']))
            $params["callDateTime"] = $options['call_date_time'];
        if(isset($options['campaign_name']))
            $params["campaignName"] = $options['campaign_name'];

        $this->url = parent::BASE_LOCAL_DOMAIN_V2 . parent::POST_MULTIPLE_SIMPLE_CALL;

        return $this->makeCall($this->url, $params);
    }

    /**
     * @param $phones [{"phoneNumber": "0707071290", "user_amount": 200}, {"phoneNumber": "0707070136", "user_amount": 400}]
     * @param $scenarioId
     * @param array $options
     * @return array
     */
    public function postMultipleDynamicCall ($phones, $scenarioId, $options=[])
    {
        $phones = json_decode($phones);
        $phones_osix = [];
        if(!is_array($phones) || empty($phones))
            return $this->error("You have to send an array of phone numbers");

        if(!NumberHelper::isValidArrayPhoneNumbers($phones))
            return $this->error("You have to provide a valid phone numbers");

        foreach ($phones as $phoneNumber) {
            if(is_string($phoneNumber))
                $phoneNumber = json_decode($phoneNumber);

            if(!property_exists($phoneNumber, "phoneNumber"))
                return $this->error("Please provide a phoneNumber property for the object");

            if(!NumberHelper::isValidNationalNumber($phoneNumber->phoneNumber))
                return $this->error("incorrect format for phone number $phoneNumber->phoneNumber");


            array_push($phones_osix, ["phone" => $phoneNumber->phoneNumber]);
        }

        $params = [
            'login' => $this->username,
            'password' => $this->password,
            'scenarioId' => $scenarioId,
            'users' => json_encode($phones_osix)
        ];

        if(isset($options['sda']))
            $params["sda"] = $options['sda'];
        if(isset($options['call_date_time']))
            $params["callDateTime"] = $options['call_date_time'];
        if(isset($options['campaign_name']))
            $params["campaignName"] = $options['campaign_name'];

        $this->url = parent::BASE_LOCAL_DOMAIN_V2 . parent::POST_MULTIPLE_DYNAMIC_CALL;

        return $this->makeCall($this->url, $params);
    }

    /**
     * @author ABDELHAMID RAHMAOUI
     * @version 1.0
     * @param string $url
     * @param string $params
     * @return array
     */
    public function makeCall ($url, $params)
    {
        $response = $this->client->request('POST', $url, ['form_params' => $params]);

        if($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if($result->status == 1)
                return $this->success($result->message, $result->data);
            else
                return $this->error($result->message);
        } else {
            return $this->error("error while processing");
        }
    }
}
