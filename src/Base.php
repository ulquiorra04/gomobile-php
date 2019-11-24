<?php

namespace Gomobile\SDK;

class Base {

    protected $client;
    protected $username;
    protected $password;
    protected $demo;

    const BASE_LOCAL_DOMAINE = "http://172.30.30.30/";
    const BASE_GLOBAL_DOMAINE = "http://www.osix.xyz/";
    const SINGLE_STATIC_CALL = "backoffice/ScenariosUsers/makeSingleStaticCall";
    const MULTIPLE_STATIC_CALL = "backoffice/ScenariosUsers/makeMultipleStaticCall";
    const SINGLE_DYNAMIC_CALL = "backoffice/ScenariosUsers/makeSingleDynamicCall";
    const MULTIPLE_DYNAMIC_CALL = "backoffice/ScenariosUsers/makeMultipleDynamicCall";
    const SCENARIO_LIST = "backoffice/Scenarios/getScenarios";
    const SCENARIO_SINGLE = "backoffice/Scenarios/getScenario";
    const SCENARIO_ADD = "backoffice/Scenarios/addScenario";
    const SCENARIO_AUDIO_LIST = "";
    const SCENARIO_AUDIO_ADD = "";
    const CAMPAIGN_LIST = "backoffice/Campaigns/getCampaigns";
    const CAMPAIGN_SINGLE = "backoffice/Campaigns/getCampaigns";
    const CAMPAIGN_SINGLE_NAME = "backoffice/Campaigns/getCampaignsWithName";
    const CAMPAIGN_VALIDATION = "backoffice/Campaigns/validateCampaign";
    const LOG_LIST = "backoffice/Logs/getLogs";
    
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