<?php

namespace Gomobile\GomobileBundle\src;

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
            $result = json_decode($response->getBody()->getContents());
            if($result->status == 1)
                return $this->success($result->message, $result->data);
            else
                return $this->error($result->message);
        } else
            return $this->error("error while processing");
	}

	/**
	 * get Single Campaign
	 * @param campaignId
	 */
	public function getCampaign ($campaignId)
	{
        $url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        $url .= parent::CAMPAIGN_SINGLE;

        $response = $this->client->request('POST', $url, [
            'form_params' => [
                'login' => $this->username,
                'password' => $this->password,
                'campaignId' => $campaignId
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
     * get Single Campaign
     * @param campaignId
     */
    public function getCampaignWithName ($campaign_name)
    {
        $url = ($this->demo) ? parent::BASE_LOCAL_DOMAINE : parent::BASE_GLOBAL_DOMAINE;
        $url .= parent::CAMPAIGN_SINGLE_NAME;

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