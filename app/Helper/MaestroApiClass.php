<?php

use App\Models\Maestro;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
/**
 * Class MaestroApiClass.
 * Reusable Maestro API call class.
 * @package Maestro
 * @package Client
 */

class MaestroApiClass
{
    public int $paging;
    public array $responseData;
    public string $maestroUrl;
    public int $maestroId;
    public string $urlQuery;
    public string $filter;
    private string $clientId;
    private string $clientSecret;
    private string $token;


    /**
     * Constructs a object of the MaestroAPIClass
     * @param int $id Accepts an maestro id
     * @param string $urlQuery accepts a filter url to attach to api call
     * @param array $filters additional filters can be attached to array and passed
     * @return object
     */
    public function __construct(int $id, string $urlQuery, array $filters)
    {
        //builds the api call'
        $this->maestroId = $id;
        $this->set_Client_Info();
        $this->maestroUrl = Maestro::query()->where('id', $id)->firstOrFail()->url;
        $this->urlQuery = $urlQuery;
        $this->get_token();
        $this->filter = !empty($filters) ? $this->set_filter($filters) : '';
    }

    /**
     * Assigns the correct API Credentials for the API call. 
     * @return void
     */

    private function set_Client_Info()
    {
        if ($this->maestroId == 1) {
            $this->clientId = config('app.CLIENT_ID_SECOND');
            $this->clientSecret = config('app.CLIENT_SECRET_SECOND');
        }
        if ($this->maestroId == 2) {
            $this->clientId = config('app.CLIENT_ID_FIRST');
            $this->clientSecret = config('app.CLIENT_SECRET_FIRST');
        }
        
    }

    /**
     * Filters additional queries
     * @return array 
     */
    private function set_filter(array $array)
    {
        //builds the filter for the api, its optional
        return  $this->filter = http_build_query($array);
    }


    /**
     * returns filters in HTTP encoded string
     * @return string
     */
    public function get_filter()
    {
        //return filter to check for errors
        return $this->filter;
    }


    /**
     * 
     * Return the url
     * @return string
     */
    function get_Url()
    {
        //returns url called
        return $this->maestroUrl;
    }

    /**
     * Return the API bearer token
     * @return string
     */
    public function get_token()
    {
        // Request a token from the 
        try{
        $token_request = new Client(['verify' => false]);
        $response = $token_request->post($this->maestroUrl . '/access/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret
            ],
            "timeout"=>config('app.API_TIME_OUT')
        ]);
        return $this->token = json_decode($response->getBody()->getContents())->access_token;
    }
        catch(GuzzleException $e){
            Log::critical($e);
           return $this->token=false;   
        }
    }

    /**
     * Calls the API instance
     * @return Object
     */
    function call_api()
    {
        if(!$this->token) return false;
        //set client to false to access the api
        $api_request = new Client(['verify' => false]);
    
        //calls api
        $api_raw_response = $api_request->get($this->maestroUrl . $this->urlQuery . '?' . $this->filter, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ]
        ]);
        //gets the actually data from the response
        $api_data = json_decode($api_raw_response->getBody()->getContents());
        //checks the data if pagination is needed.
        if ($api_data->paging->total > $api_data->paging->limit) {

            //set total number of objects
            $api_object_total = $api_data->paging->total;
            //sets the limit of return by each
            $api_objects_limit = $api_data->paging->limit;
            $api_request = new Client(['verify' => false]);
            for ($counter = $api_objects_limit; $counter < $api_object_total; $counter += $api_objects_limit) {
                //builds query builder for offset
                $api_new_query = http_build_query(array(
                    'offset' => $counter,

                ));
                //calls api again for the data
                $api_raw_response = $api_request->get($this->maestroUrl . $this->urlQuery . '?' . $api_new_query . '&' . $this->filter, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                    ]
                ]);
                //get the data
                $data = json_decode($api_raw_response->getBody()->getContents());
                //merges data in a single object
                $api_data->data = array_merge($api_data->data, $data->data);
            }
        }

        $this->paging = $api_data->paging->total;
        //also returns data
        return $this->response_data = $api_data->data;
    }

    /**
     * returns the API DATA
     * @return object
     */

    function get_response_data()
    {
        //returns the api data in array
        return $this->response_data;
    }

    /**
     * Returns the total amount of objects returned by the API call
     * @return int
     */
    function get_paging()
    {
        //returns the api paging
        return $this->paging;
    }
    /**
     * Destructor
     * @return void
     */
    public function __destruct()
    {
    }
}
