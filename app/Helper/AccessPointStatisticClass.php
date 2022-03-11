<?php

use PhpParser\Builder\Class_;
use App\Models\Maestro;
use GuzzleHttp\Client;


class AccessPointStatisticHelperClass
{
    public string $maestro;
    private string $clientId;
    private string $clientSecret;
    private string $api_append;
    public string $url;
    public string $page;
    public string $filter;
    public array $reponse_data;
    function __construct(String $maestro, String $clientId, String $clientSecret,String $api_append)
    {
        $this->maestro = $maestro;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->api_append = $api_append;
        $this->set_url_query(array('mode'=>'ap'));
    }
    function get_maestro()
    {
        return $this->maestro;
    }
    function get_client()
    {
        return $this->clientId;
    }
    function set_url_query(array $array)
    {
        $this->filter = http_build_query($array);
    }
    function get_url_query()
    {
        return $this->filter;
    }
    function get_token()
    {
        $token_request = new Client(['verify' => false]);

        $response = $token_request->post($this->maestro . '/access/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret
            ]

        ]);
        $data = json_decode($response->getBody()->getContents());
        $token = $data->access_token;
        return $token;
    }

    function call_api()
    {
        $api_request = new Client(['verify' => false]);
        $api_raw_response = $api_request->get($this->maestro . $this->api_append.'?'.$this->filter,[
            'headers' => [
                'Authorization' => 'Bearer ' . $this->get_token(),
            ]
        ]);
        $api_data = json_decode($api_raw_response->getBody()->getContents());
        $this->reponse_data= $api_data->data;
    }


    function get_response_data()
    {
        return $this->reponse_data;
    }
}



//not using