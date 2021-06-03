<?php

class OneDriveDelta
{

    private $token;

    public function __construct()
    {
        $authToken = new AuthToken();
        $token = $authToken->getToken();
        $this->token = $token;
    }

    public function getDeltaLinkToken()
    {
        $client = new \GuzzleHttp\Client();
        $deltaUrl = 'https://graph.microsoft.com/v1.0/drives/b!qr6_XPV0S0qNpOz8TMRdZIB0lzTYzKlJpLDrr8K98DuIA1lgGJHzSr7mwkS_W6_k/root/delta?deltaToken=latest';
        $deltaLink = (array) json_decode($client->request('get', $deltaUrl, [
            'headers' => [
                'Authorization' => $this->token,
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
            ]
        ])->getBody()->getContents());

        $token = preg_replace('/(.*)token=\'(.*)\'\)?(.*)/sm', '\2', $deltaLink['@odata.deltaLink']);

        return $token;
    }

    function getChangedFile($deltaLinkToken)
    {
        $client = new \GuzzleHttp\Client();
        $url = "https://graph.microsoft.com/v1.0/drives/b!qr6_XPV0S0qNpOz8TMRdZIB0lzTYzKlJpLDrr8K98DuIA1lgGJHzSr7mwkS_W6_k/root/delta?token=$deltaLinkToken";
        $changedFiles = json_decode($client->request('get', $url, [
            'headers' => [
                'Authorization' => $this->token,
                'accept' => 'application/json',
            ]
        ])->getBody()->getContents(), true);
        if (isset($changedFiles['value'])) {
            return $changedFiles['value'];
        }

        return [];
    }
}
