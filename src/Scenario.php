<?php

namespace Gomobile\SDK;

class Scenario extends Base {

	public function getScenarios () {
		$url = parent::BASE_DOMAINE . parent::SINGLE_STATIC_CALL;
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

}