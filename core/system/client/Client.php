<?php

namespace Core\System\Client;

use GuzzleHttp\Psr7\Request;

require_once __DIR__ . '/../../../core/includes/autoload.php';

require_once __DIR__ . '/../../../core/system/client/parser/keys_mapper.php';
require_once __DIR__ . '/../../../core/system/client/parser/xml_parser.php';


//Curl code goes here as per config endpoints

class Client
{
    private \GuzzleHttp\Client $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();

    }

    /**
     * @param $request_url
     * @param string $request_type
     * @param array $data
     * @return bool|string
     * @throws \Exception
     */
    public function sendRequest($request_url, $request_type='POST', $data=[]) // TODO::Change
    {
        try {

            $request = new Request($request_type, $request_url, ($data['headers'] ?? []));

            unset($data['headers']);

            $response = $this->client->send($request, $data);
            $content = $response->getBody();
            $content->rewind();
            return (string)$content->getContents();

        } catch(\Exception $e) {
            sendLogToSlack(
                "There is some problem during send send request on pms.",
                [
                    __FILE__,
                    __FUNCTION__,
                    $e->getMessage(),
                    $e->getTraceAsString()
                ]
            );
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

}