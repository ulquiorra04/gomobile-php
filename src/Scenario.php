<?php

namespace Gomobile\GomobileBundle\src;

class Scenario extends Base {

    private $url;

    public function __construct($client, $username, $password, $demo = false)
    {
        $this->url = ($demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        parent::__construct($client, $username, $password, $demo);
    }

    /**
	 * GET List of scenarios
	 * 
	 * @return Array of scenarios
	 */
	public function getScenarios () {
		$this->url .= parent::SCENARIO_LIST;
		$response = $this->client->request('POST', $this->url, [
						'form_params' => [
							'login' => $this->username,
							'password' => $this->password
						]
					]);
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
	 * GET Single Scenario
	 * 
	 * @param int ScenarioId
	 * @return Object Scenario
	 */
	public function getScenario ($scenarioId) {
		$this->url .= parent::SCENARIO_SINGLE;
		$response = $this->client->request('POST', $this->url, [
						'form_params' => [
							'login' => $this->username,
							'password' => $this->password,
							'scenarioId' => $scenarioId
						]
					]);
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
	 * ADD Scenario method
	 * 
	 * @param string name The scenario name
	 * @return int scenarioId
	 */
	public function addScenario ($name) {
		$this->url .= parent::SCENARIO_ADD;
		$response = $this->client->request('POST', $this->url, [
							'form_params' => [
								'login' => $this->username,
								'password' => $this->password,
								'name' => $name
							]
						]);
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

	public function getAudiosScenario ($scenarioId) {
		$this->url .= parent::SCENARIO_AUDIO_LIST;
		$response = $this->client->request('POST', $this->url, [
							'form_params' => [
								'login' => $this->username,
								'password' => $this->password,
								'scenarioId' => $scenarioId
							]
						]);
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
     * @param $name
     * @param $order
     * @param $file_path
     * @param $scenarioId
     * @return array
     */
	public function addSimpleAudioScenario ($name, $order, $file_path, $scenarioId) {
		if(file_exists($file_path))
			return $this->addAudioScenario($name, 1, $order, $file_path, $scenarioId);
		else
			return $this->error("File not found");
	}

    /**
     * @param $name
     * @param $order
     * @param $file_path
     * @param $scenarioId
     * @return array
     */
	public function addInteractiveAudioScenario ($name, $order, $file_path, $scenarioId) {
		if(file_exists($file_path))
			return $this->addAudioScenario($name, 159, $order, $file_path, $scenarioId);
		else
			return $this->error("File not found");
	}

    /**
     * @param $name
     * @param $order
     * @param $file_path
     * @param $scenarioId
     * @return array
     */
	public function updateInteractiveAudioScenario ($name, $order, $file_path, $scenarioId) {
        if(file_exists($file_path))
            return $this->updateAudioScenario($name, 159, $order, $file_path, $scenarioId);
        else
            return $this->error("File not found");
    }

	/**
	 * ADD Dynamic Audio to Scenario
	 * 
	 * @param string name
	 * @param int order in scenario
	 * @param string filePath
	 * @param int voice to be used SAMI => 2 | HANANE => 1
	 * @param int metadata type of dynamic LIST => 1 | SUITE => 2 | NUMBER => 3 | DATE => 4
     *
     * @return array
	 */
	public function addDynamicAudioScenario ($name, $order, $file_path, $scenarioId, $voiceId, $metadata) {
		$allowed_metadata = array(1, 2, 3, 4);
		if(!in_array($metadata, $allowed_metadata))
			return $this->error("Metadata not allowed");
		if(file_exists($file_path))
			return $this->addAudioScenario($name, 27, $order, $file_path, $scenarioId, $voiceId, $metadata);
		else
			return $this->error("File not found");
	}

	private function addAudioScenario ($name, $type, $order, $file_path, $scenario, $voiceId = 0, $metadata = 0) {
		$this->url .= parent::SCENARIO_AUDIO_ADD;
		$response = $this->client->request('POST', $this->url, [
							'multipart' => [
							    ['name' => 'login', 'contents' => $this->username],
                                ['name' => 'password', 'contents' => $this->password],
                                ['name' => 'scenarioId', 'contents' => $scenario],
                                ['name' => 'name', 'contents' => $name],
                                ['name' => 'type', 'contents' => $type],
                                ['name' => 'order', 'contents' => $order],
                                ['name' => 'voice', 'contents' => $voiceId],
                                ['name' => 'metadata', 'contents' => $metadata],
								[
									'name' => 'audio_file',
									'contents' => fopen($file_path, "r")
								]
							]
						]);
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

    private function updateAudioScenario ($name, $type, $order, $file_path, $scenario, $voiceId = 0, $metadata = 0)
    {
        $this->url .= parent::SCENARIO_AUDIO_EDIT;
        $response = $this->client->request('POST', $this->url, [
            'multipart' => [
                ['name' => 'login', 'contents' => $this->username],
                ['name' => 'password', 'contents' => $this->password],
                ['name' => 'scenarioId', 'contents' => $scenario],
                ['name' => 'name', 'contents' => $name],
                ['name' => 'type', 'contents' => $type],
                ['name' => 'order', 'contents' => $order],
                ['name' => 'voice', 'contents' => $voiceId],
                ['name' => 'metadata', 'contents' => $metadata],
                [
                    'name' => 'audio_file',
                    'contents' => fopen($file_path, "r")
                ]
            ]
        ]);
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