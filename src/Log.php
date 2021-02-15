<?php

namespace Gomobile\GomobileBundle\src;

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