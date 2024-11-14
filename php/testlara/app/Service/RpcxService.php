<?php

namespace app\Service;

class RpcxService
{
    protected $url;

    public function __construct($url="http://192.168.72.130:8003")
    {
        $this->url = $url;
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
