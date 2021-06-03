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
        // $subscription = $this->client->request('POST', $this->url, [
        //     'json' => [
        //         "changeType" => "updated",
        //         "notificationUrl" => "https://0f783a6091a7.ngrok.io/callback.php",
        //         "resource" => "/drive/root",
        //         "expirationDateTime" => "2021-06-28T11:23:00.000Z",
        //     ],
        //     'headers' => [
        //         'Content-Type' => 'application/json',
        //         'Accept' => 'application/json',
        //         'Authorization' => $this->token,
        //     ]
        // ])->getBody()->getContents();

        // return json_decode($subscription, true);


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.microsoft.com/v1.0/subscriptions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
 "changeType": "updated",
 "notificationUrl": "https://0f783a6091a7.ngrok.io/callback.php",
 "resource": "/drive/root",
 "expirationDateTime": "2021-06-28T11:23:00.000Z"
}',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization:Bearer eyJ0eXAiOiJKV1QiLCJub25jZSI6ImswNE9RZnJMdmJBSkRzZDJJc2hWbGVrakVjNXU4bzRvUjNCMElUWXkxbm8iLCJhbGciOiJSUzI1NiIsIng1dCI6Im5PbzNaRHJPRFhFSzFqS1doWHNsSFJfS1hFZyIsImtpZCI6Im5PbzNaRHJPRFhFSzFqS1doWHNsSFJfS1hFZyJ9.eyJhdWQiOiJodHRwczovL2dyYXBoLm1pY3Jvc29mdC5jb20iLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC84NzNkNDQ1MS01Nzc0LTQxMWItYWFjYi00ZTgzYTcyNWVkMGIvIiwiaWF0IjoxNjIyNzE2NzY4LCJuYmYiOjE2MjI3MTY3NjgsImV4cCI6MTYyMjcyMDY2OCwiYWlvIjoiRTJaZ1lQaXRzRFZnYW9HbmdsZTlnV2VnOFI5VEFBPT0iLCJhcHBfZGlzcGxheW5hbWUiOiJXZWJvIiwiYXBwaWQiOiI4YmE5YTdiMy0wNzgxLTQ5MzktYjMxMS1mZDhmMWQ2N2FlZjYiLCJhcHBpZGFjciI6IjEiLCJpZHAiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC84NzNkNDQ1MS01Nzc0LTQxMWItYWFjYi00ZTgzYTcyNWVkMGIvIiwiaWR0eXAiOiJhcHAiLCJvaWQiOiI3NWE5MWRhYS1mNjcyLTQ2NWQtOGYxMi0wMThiY2U5NWE0OTEiLCJyaCI6IjAuQVhBQVVVUTloM1JYRzBHcXkwNkRweVh0QzdPbnFZdUJCemxKc3hIOWp4MW5ydlp3QUFBLiIsInJvbGVzIjpbIkZpbGVzLlJlYWRXcml0ZS5BbGwiLCJGaWxlcy5SZWFkLkFsbCJdLCJzdWIiOiI3NWE5MWRhYS1mNjcyLTQ2NWQtOGYxMi0wMThiY2U5NWE0OTEiLCJ0ZW5hbnRfcmVnaW9uX3Njb3BlIjoiQVMiLCJ0aWQiOiI4NzNkNDQ1MS01Nzc0LTQxMWItYWFjYi00ZTgzYTcyNWVkMGIiLCJ1dGkiOiJKU2sxdkVRMDFrT0h2azQwSHNrQUFBIiwidmVyIjoiMS4wIiwid2lkcyI6WyIwOTk3YTFkMC0wZDFkLTRhY2ItYjQwOC1kNWNhNzMxMjFlOTAiXSwieG1zX3RjZHQiOjE2MjI0NTYyOTJ9.A9stG5-9Hn71ACeizJB0KJtNw-N1G_m1-GmfZgI-yMXY3ekmxbMYhjUrQaUIU9j-TfH9sd4q5hffaqLJXwGUi2AYNvFy9Uyuagz16UFdSFqYSQobm-K8CKXvA3cvNdYPSBfT7Lpa7fDmZ0BUqkjfR3wm7BMNKR6wRIm8cNtQy1adQ8ffJy2C2A5JwZENiurVl-eFRv4_4RKVDjc3ugKsvBXONKaNUBYQGujnmMSXcIZ5GEjmlUE1SgN9HR6ndXB5TXHjiZPzo1xbn3s6YIl2spNWm7PUFGj4YxoK1SH75Vk7I1CF1aNpA65Jt5zvvWXthfK9KnIW199WK1kR1Yu_Tw'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
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
