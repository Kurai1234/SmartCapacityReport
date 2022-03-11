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
    public string $page;
    public string $filter;
    public int $paging;
    public array $response_data;
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
        $api_raw_response = $api_request->get($this->maestro . $this->api_append . '?' . $this->filter, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->get_token(),
            ]
        ]);
        $api_data = json_decode($api_raw_response->getBody()->getContents());
        $this->response_data= $api_data->data;
        $this->paging = $api_data->paging->total;

        // if ($api_data->paging->total > $api_data->paging->limit) {
        //     $api_object_total = $api_data->paging->total;
        //     $api_objects_limit = $api_data->paging->limit;
        //     for ($counter = $api_objects_limit; $counter < $api_object_total; $counter += $api_objects_limit) {
        //         $api_url_query = array(
        //             'mode' => 'ap',
        //             'offset' => $counter,

        //         );
        //         $this->set_url_query($api_url_query);
        //         // $api_new_query = http_build_query($api_url_query);

        //         $api_raw_response = $api_request->get(env('MAESTRO_SECOND_SERVER') . '/devices/statistics?' . $this->filter, [
        //             'headers' => [
        //                 'Authorization' => 'Bearer ' . $this->get_token(),
        //             ]
        //         ]);
        //         $api_data->data = array_merge($api_data->data, json_decode($api_raw_response->getBody()->getContents())->data);
        //     }
        // }



        return $api_data;
    }


    function get_response_data()
    {
        // $this->call_api();

        return $this->response_data;
    }
    function get_paging(){
        return $this->paging;
    }
}



//not using