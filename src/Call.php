<?php

namespace Gomobile\SDK;

class Call extends Base {
    
    public function makeSingleStaticCall ($phoneNumber, $scenarioId) {
        $url = parent::BASE_DOMAINE . parent::SINGLE_STATIC_CALL;
        $response = $this->client->request('POST', $url, [
                        'form_params' => [
                            'login' => $this->username,
                            'password' => $this->password,
                            'scenarioId' => $scenarioId,
                            'user' => json_encode(["phoneNumber" => $phoneNumber])
                        ]
                    ]);
        if($response->getStatusCode() == 200) {
            $this->success($response->getBody());
        } else {
            $this->error("error while processing");
        }
    }

}