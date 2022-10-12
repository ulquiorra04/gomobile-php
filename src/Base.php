<?php

namespace Gomobile\GomobileBundle\src;

class Base {

    protected $client;
    protected $username;
    protected $password;
    protected $demo;

    const BASE_LOCAL_DOMAINE = "http://172.30.30.30/backoffice/";
    const BASE_GLOBAL_DOMAINE = "http://www.osix.xyz/backoffice/";

    const BASE_LOCAL_DOMAIN_V2 = "http://10.40.1.91:81/external/";

    const SINGLE_STATIC_CALL = "ScenariosUsers/makeSingleStaticCall";
    const MULTIPLE_STATIC_CALL = "ScenariosUsers/makeMultipleStaticCall";
    const SINGLE_DYNAMIC_CALL = "ScenariosUsers/makeSingleDynamicCall";
    const MULTIPLE_DYNAMIC_CALL = "ScenariosUsers/makeMultipleDynamicCall";
    const DIRECT_CALL = "ScenariosUsers/makeDirectCall";

    const POST_MULTIPLE_SIMPLE_CALL = "post_simple_call";
    const POST_MULTIPLE_DYNAMIC_CALL = "post_dynamic_call";

    const SCENARIO_LIST = "Scenarios/getScenarios";
    const SCENARIO_SINGLE = "Scenarios/getScenario";
    const SCENARIO_ADD = "Scenarios/addScenario";
    const SCENARIO_AUDIO_LIST = "";
    const SCENARIO_AUDIO_ADD = "Scenarios/addAudioToScenario";
    const SCENARIO_AUDIO_EDIT = "Scenarios/updateAudioToScenario";
    const CAMPAIGN_LIST = "Campaigns/getCampaigns";
    const CAMPAIGN_SINGLE = "Campaigns/getCampaigns";
    const CAMPAIGN_SINGLE_NAME = "Campaigns/getCampaignsWithName";
    const CAMPAIGN_VALIDATION = "Campaigns/validateCampaign";
    const LOG_LIST = "Logs/getLogs";
    const BULK_FILE_WRITER = "ScenariosUsers/saveSUData";

    public function __construct ($client, $username, $password, $demo=false) {
        $this->client = $client;
        $this->username = $username;
        $this->password = $password;
        $this->demo = $demo;
    }

    public function error ($message) {
        return [
            "status" => 0,
            "description" => $message,
        ];
    }

    public function success ($message, $options) {
        return [
            'status' => 1,
            'description' => $message,
            "options" => $options
        ];
    }

}
