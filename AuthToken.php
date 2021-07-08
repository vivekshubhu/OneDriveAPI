<?php

class AuthToken
{
    private $tenantId = "1fcbc3e3-8c2a-4e70-9451-a3ea63f56f38";
    private $clientId = "f6e0d0cc-8387-4002-be55-562a2c2675d9";
    private $clientSecret = "8iq.e8er4A-ov86Ct22__XzmQzYk03aTrD";
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
