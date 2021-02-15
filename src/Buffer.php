<?php

namespace Gomobile\GomobileBundle\src;
use Gomobile\GomobileBundle\lib\NumberHelper;
use Gomobile\GomobileBundle\lib\ParameterHelper;

class Buffer extends Base {
    private $parameterHelper;

    public function __construct ($client, $username, $password, $demo=false) {
        $this->parameterHelper = new ParameterHelper();
        parent::__construct($client, $username, $password, $demo);
    }

    /**
     * Send a buffer of data to be written in a file
     *
     * @param array $users [{"phoneNumber": "0707071290", "user_amount": 300}, {"phoneNumber": "0707071290", "user_amount": 200}]
     * @param int $scenarioId
     * @param array $options [sda => "05XXXXXXXX"]
     *
     * @return json
     */
    public function sendBulkMultipleDynamicCall ($users, $scenarioId, $options = []){
        $users = json_decode($users);

        if(!is_array($users) || empty($users))
            return $this->error("Either you provided an empty table or not a table");

        foreach($users as $user) {
            if(is_string($user))
                $user = json_decode($user);

            if(!property_exists($user, "phoneNumber"))
                return $this->error("Please provide a phoneNumber property for the object");
            if(!NumberHelper::isValidNationalNumber($user->phoneNumber))
                return $this->error("incorrect format for phone number $user->phoneNumber");
            if(!$this->parameterHelper->isSupportedParameters($user))
                return $this->error("You have send a non supported parameter");
        }
        // Prepare to make the call
        $url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        $url .= parent::BULK_FILE_WRITER;
        $params = [
            'login' => $this->username,
            'password' => $this->password,
            'scenarioId' => $scenarioId,
            'users' => json_encode($users)
        ];
        if(isset($options['sda']))
            $params["sda"] = $options['sda'];
        if(isset($options['call_date_time']))
            $params["callDateTime"] = $options['call_date_time'];
        if(isset($options['campaign_name']))
            $params["campaignName"] = $options['campaign_name'];
        $response = $this->client->request('POST', $url, ['form_params' => $params]);

        if($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if($result->status == 0)
                return $this->error($result->message);
            else
                return $this->success($result->message, $result->data);
            
        }else
            return $this->error("error while processing");

    }
}
