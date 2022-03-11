<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;




function hectorDextorBextor(){
    return "Hectormexkor";
}

if(!function_exists('get_maestro_api_token')){
    function get_maestro_api_statistic(){
        $token_request = new Client(['verify'=>false]);
        $response = $token_request->post(env('MAESTRO_SECOND_SERVER') . '/access/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => env('CLIENT_ID_SECOND'),
                'client_secret' => env('CLIENT_SECRET_SECOND')
            ]
        ]);
        $data = json_decode($response->getBody()->getContents());
        $token = $data->access_token;

        $api_request = new Client(['verify' => false]);
            $api_raw_response = $api_request->get(env('MAESTRO_SECOND_SERVER') . '/devices/statistics?mode=ap', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);
       
        if (!$api_raw_response) return;
        $api_data = json_decode($api_raw_response->getBody()->getContents());
        $api_object_total = $api_data->paging->total;
        $api_objects_limit = $api_data->paging->limit;
        $pagin_necessary = $api_object_total > $api_objects_limit ? true : false;
        if ($pagin_necessary) {
            $api_request = new Client(['verify' => false]);

            for ($counter = $api_objects_limit; $counter < $api_object_total; $counter += $api_objects_limit) {
                $api_url_query = array(
                    'mode' => 'ap',
                    'offset' => $counter,

                );
                $api_new_query = http_build_query($api_url_query);
                try {
                    $api_raw_response = $api_request->get(env('MAESTRO_SECOND_SERVER') . '/devices/statistics?' . $api_new_query, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $token,
                        ]
                    ]);
                    $api_data->data = array_merge($api_data->data, json_decode($api_raw_response->getBody()->getContents())->data);
                } catch (BadResponseException $err) {

                    $api_raw_response = false;

                    //add error handlers
                }
                if (!$api_raw_response) return;
            }
        }
        return $api_data->data;
    }

}

