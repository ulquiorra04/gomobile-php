<?php

namespace Gomobile\SDK;

class Log extends Base
{

	public function getLogs ($campaign_name)
	{
		$url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        $url .= parent::LOG_LIST;

        $response = $this->client->request('POST', $url, [
            'form_params' => [
                'login' => $this->username,
                'password' => $this->password,
                'campaign_name' => $campaign_name
            ]
        ]);
        
        if($response->getStatusCode() == 200) {
            return $this->success($response->getBody()->getContents());
        } else {
            return $this->error("error while processing");
        }
	}
}