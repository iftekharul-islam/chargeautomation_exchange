<?php

use GuzzleHttp\Client;

function requestToApi($end_point, $headers = [], $form_params = [])
{
    //TODO check environment local or not
    $url = ['base_uri' => 'http://localhost'];

    $request_parameters = array_merge($url, $headers);
    $client = new Client($request_parameters);
    //$response = $client->get($api);
    $response = $client->request('POST', $end_point, [
        'form_params' => $form_params
    ]);
    return $response->getBody()->getContents();
}