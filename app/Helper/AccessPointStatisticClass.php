<?php

use PhpParser\Builder\Class_;
use App\Models\Maestro;
use GuzzleHttp\Client;
use Ramsey\Uuid\Type\Integer;

class AccessPointStatisticHelperClass
{
    public string $maestro;
    private string $clientId;
    private string $clientSecret;
    private string $api_append;
    public string $url;
    public string $filter;
    public int $paging;
    public array $response_data;
    //constructor ask for a url link, the client id, the client secret, and the api format url
    function __construct(String $maestro, String $clientId, String $clientSecret, String $api_append)
    {
        $this->maestro = $maestro;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->api_append = $api_append;
        // $this->response_data;
        $this->set_url_query(array());
    }
    function get_maestro()
    {
        //returns  the amestro api link
        return $this->maestro;
    }
    // function get_client()
    // {
    //  was for testing the output
    //     return $this->clientId;
    // }
    function set_url_query(array $array)
    {
        //builds the filter for the api, its optional
        $this->filter = http_build_query($array);
    }
    function get_url_query()
    {
        //reutnrs filter
        return $this->filter;
    }
    function get_token()
    {
        // Request a token from the api
        $token_request = new Client(['verify' => false]);
<<<<<<< HEAD
=======
        
>>>>>>> e43c0d0b2139926db0a2e1dbe942610cb2eb2d5c
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
        //request data from the api
        $api_request = new Client(['verify' => false]);
        $api_raw_response = $api_request->get($this->maestro . $this->api_append . '?' . $this->filter, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->get_token(),
            ]
        ]);
        $api_data = json_decode($api_raw_response->getBody()->getContents());

        if ($api_data->paging->total > 100) {
            $api_object_total = $api_data->paging->total;
            $api_objects_limit = $api_data->paging->limit;
            $api_request = new Client(['verify' => false]);
            for ($counter = $api_objects_limit; $counter < $api_object_total; $counter += $api_objects_limit) {
                $api_url_query = array(
                    'offset' => $counter,

                );
                $api_new_query = http_build_query($api_url_query);

                $api_raw_response = $api_request->get($this->maestro . $this->api_append . '?' . $api_new_query .'&'. $this->filter, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->get_token(),
                    ]
                ]);
                $data= json_decode($api_raw_response->getBody()->getContents());
                $api_data->data = array_merge($api_data->data, $data->data);
            }
        }

        $this->response_data = $api_data->data;
        $this->paging = $api_data->paging->total;


        return $api_data;
    }


    function get_response_data()
    {
        //returns the api data in array

        return $this->response_data;
    }
    function get_paging()
    {
        //returns the api paging
        return $this->paging;
    }
}
