<?php
require __DIR__ . './AuthToken.php';

class Subscription
{
    private $client;
    private $token;
    private $url;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $authToken = new AuthToken();
        $this->token = $authToken->getToken();
        $this->url = 'https://graph.microsoft.com/v1.0/subscriptions';
    }

    public function get()
    {
        $subscriptions = (array) json_decode($this->client->request('get', $this->url, [
            'headers' => [
                'Authorization' => $this->token,
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
            ]
        ])->getBody()->getContents());

        return $subscriptions['value'];
    }

    public function create()
    {
        $subscription = $this->client->request('POST', $this->url, [
            'json' => [
                "changeType" => "updated",
                "notificationUrl" => "https://c42e85a7029c.ngrok.io/callback.php",
                "resource" => "/drive/root",
                "expirationDateTime" => "2021-06-28T11:23:00.000Z",
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => $this->token,
            ]
        ])->getBody()->getContents();

        return json_decode($subscription, true);
    }

    public function update($expireTime, $id)
    {
        $subscription = json_decode($this->client->request('PATCH', $this->url . "/$id", [
            'json' => [
                "expirationDateTime" => $expireTime,
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => $this->token,
            ]
        ])->getBody()->getContents());

        return $subscription;
    }

    public function delete($id)
    {
        $subscriptions = (array) json_decode($this->client->request('delete', $this->url . "/$id", [
            'headers' => [
                'Authorization' => $this->token,
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
            ]
        ])->getBody()->getContents());

        return $subscriptions;
    }
}
