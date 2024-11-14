<?php

namespace app\Service;

use GuzzleHttp\Client;

class RpcxService
{
    protected $url;
    protected $client;

    public function __construct($url="http://192.168.72.130:8003")
    {
        $this->client = new Client();
        $this->url = $url;
    }

    public function callHttpRpc($params)
    {
        $data = [
            'json' => [
                'method' => 'Arith.Multiply',
                'params' => [$params],
            ]
        ];
        $response = $this->client->post($this->url, $data);
        $body = json_decode($response->getBody()->getContents(), true);
        return $body;
    }


    public function callRpcx($servicePath,$serviceMethod,$method,$params)
    {
        $data = json_encode($params);
        $options = [
            'http' => [
                'header' => "content-type:application/rpcx\r\n".
                    "X-RPCX-SerializeType: 1\r\n" .
                    "X-RPCX-ServicePath: {$servicePath}\r\n" .
                    "X-RPCX-ServiceMethod: {$serviceMethod}\r\n",
                'method' => $method,
                'content' => $data
            ]
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($this->url, false, $context);
        if ($result === FALSE) {
            return false;
        }

        return json_decode($result,true);
    }
}
