<?php

use PhpParser\Builder\Class_;
use App\Models\Maestro;
use GuzzleHttp\Client;


class AccessPointStatisticHelperClass
{
    public string $maestro;
    private string $clientId;
    private string $clientSecret;
    public string $url;
    public string $page;
    public string $array;
    function __construct(String $maestro, String $clientId, String $clientSecret)
    {
        $this->maestro = $maestro;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->set_url();
        $this->set_url_query(array('start_time'=>'2022/03/10 6:00','stop_time'=>'2022/03/11 8:20'));
        
    }
    function get_maestro()
    {
        return $this->maestro;
    }
    function get_client()
    {
        return $this->clientId;
    }
    function set_url_query(array $array){
        $this->array = http_build_query($array);
    }
    function get_url_query(){
        return $this->array;
    }
    function get_token(){
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

    function set_url()
    {   




  }
    function get_url()
    {
       return $this->url;
    }


    
   
}



//not using