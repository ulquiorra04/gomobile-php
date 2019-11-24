<?php

namespace Gomobile\SDK;

class Campaign extends Base {

	/**
	 * Get the list of campaigns
	 *
	 */
	public function getCampaigns ()
	{
		$url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        $url .= parent::CAMPAIGN_LIST;

        $response = $this->client->request('POST', $url, [
            'form_params' => [
                'login' => $this->username,
                'password' => $this->password,
            ]
        ]);
        
        if($response->getStatusCode() == 200) {
            return $this->success($response->getBody()->getContents());
        } else {
            return $this->error("error while processing");
        }
	}

	/**
	 * get Single Campaign
	 * @param campaignId
	 */
	public function getCampaign ($campaignId)
	{
        $url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        $url .= parent::CAMPAIGN_LIST;

        $response = $this->client->request('POST', $url, [
            'form_params' => [
                'login' => $this->username,
                'password' => $this->password,
                'campaignId' => $campaignId
            ]
        ]);
        
        if($response->getStatusCode() == 200) {
            return $this->success($response->getBody()->getContents());
        } else {
            return $this->error("error while processing");
        }
	}


	/**
     * Validate Campaign
     * @param campaignId
     *
     * @return json
     */
    public function validateCampaign ($campaignId)
    {
        $url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        $url .= parent::CAMPAIGN_VALIDATION;

        $response = $this->client->request('POST', $url, [
            'form_params' => [
                'login' => $this->username,
                'password' => $this->password,
                'campaignId' => $campaignId
            ]
        ]);
        
        if($response->getStatusCode() == 200) {
            return $this->success($response->getBody()->getContents());
        } else {
            return $this->error("error while processing");
        }
    }
}