<?php

namespace Gomobile\SDK;

class Scenario extends Base {

	/**
	 * GET List of scenarios
	 * 
	 * @return Array of scenarios
	 */
	public function getScenarios () {
		$url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
		$url .= parent::SCENARIO_LIST;
		$response = $this->client->request('POST', $url, [
						'form_params' => [
							'login' => $this->username,
							'password' => $this->password
						]
					]);
		if($response->getStatusCode() == 200)
			return $this->success($response->getBody()->getContents());
		else
			return $this->error("error while processing");
	}

	/**
	 * GET Single Scenario
	 * 
	 * @param int ScenarioId
	 * @return Object Scenario
	 */
	public function getScenario ($scenarioId) {
		$url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
		$url .= parent::SCENARIO_SINGLE;
		$response = $this->client->request('POST', $url, [
						'form_params' => [
							'login' => $this->username,
							'password' => $this->password,
							'scenarioId' => $scenarioId
						]
					]);
		if($response->getStatusCode() == 200)
			return $this->success($response->getBody()->getContents());
		else
			return $this->error("error while processing");
	}

	/**
	 * ADD Scenario method
	 * 
	 * @param string name The scenario name
	 * @return int scenarioId
	 */
	public function addScenario ($name) {
		$url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
		$url .= parent::SCENARIO_ADD;
		$response = $this->client->request('POST', $url, [
							'form_params' => [
								'login' => $this->username,
								'password' => $this->password,
								'name' => $name
							]
						]);
		if($response->getStatusCode() == 200)
			return $this->success($response->getBody()->getContents());
		else
			return $this->error("error while processing");
	}

	public function getAudiosScenario ($scenarioId) {
		$url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
		$url .= parent::SCENARIO_AUDIO_LIST;
		$response = $this->client->request('POST', $url, [
							'form_params' => [
								'login' => $this->username,
								'password' => $this->password,
								'scenarioId' => $scenarioId
							]
						]);
		if($response->getStatusCode() == 200)
			return $this->success($response->getBody()->getContents());
		else
			return $this->error("error while processing");
	}

	public function addSimpleAudioScenario ($name, $order, $file_path, $scenarioId) {
		if(file_exists($file_path))
			return $this->addAudioScenario($name, 1, $order, $file_path, $scenarioId);
		else
			return $this->error("File not found");
	}

	public function addInteractiveAudioScenario ($name, $order, $file_path, $scenarioId) {
		if(file_exists($file_path))
			return $this->addAudioScenario($name, 159, $order, $file_path, $scenarioId);
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
		$url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
		$url .= parent::SCENARIO_AUDIO_ADD;
		$response = $this->client->request('POST', $url, [
							'multipart' => [
								'login' => $this->username,
								'password' => $this->password,
								'name' => $name,
								'type' => $type,
								'order' => $order,
								'voice' => $voiceId,
								'metadata' => $metadata,
								[
									'name' => 'audio_file',
									'contents' => fopen($file_path)
								]
							]
						]);
		if($response->getStatusCode() == 200)
			return $this->success($response->getBody()->getContents());
		else
			return $this->error("error while processing");
	}


}