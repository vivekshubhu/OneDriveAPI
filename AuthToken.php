<?php

class AuthToken
{
    private $tenantId = "873d4451-5774-411b-aacb-4e83a725ed0b";
    private $clientId = "8ba9a7b3-0781-4939-b311-fd8f1d67aef6";
    private $clientSecret = "fZhn_k_VU3WKQctTF0Jn~.wHQL15-_GB8w";
    // private $redirectUrl = 'http://localhost:8000/callback.php';

    public function __construct()
    {
    }

    //Get Authorization Token
    public function getToken()
    {
        $client = new \GuzzleHttp\Client();

        $url = "https://login.microsoftonline.com/$this->tenantId/oauth2/v2.0/token";
        $user_token = json_decode($client->request('post', $url, [
            'form_params' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
                'scope' => 'https://graph.microsoft.com/.default'
            ]
        ])->getBody()->getContents());
        $token = $user_token->access_token;

        return $token;
    }
}
