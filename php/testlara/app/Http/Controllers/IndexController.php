<?php

namespace App\Http\Controllers;

use app\Service\RpcxService;
use Exception;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    protected $host;
    protected $port;
    protected $rpcxService;

    public function __construct(RpcxService $rpcxService)
    {
        $this->rpcxService = $rpcxService;
    }

    public function call($method, $params)
    {
        $socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
        if ($socket === false) {
            throw new Exception("Failed to create socket: " . socket_strerror(socket_last_error()));
        }

        $result = socket_connect($socket,$this->host,$this->port);
        if ($result === false) {
            throw new Exception("Failed to connect to server: " . socket_strerror(socket_last_error()));
        }
        $request = $this->buildRequest($method,$params);
        socket_write($socket,$request,strlen($request));
        $response = socket_read($socket,2048);
        socket_close($socket);
        return $response;
    }

    protected function buildRequest($method,$params)
    {
        $data = [
            'method' => $method,
            'params' => $params
        ];
        return json_encode($data);
    }

    public function rpcx()
    {
        $servicePath = 'Arith';
        $serviceMethod = 'Multiply';

        // 要传递给服务的参数
        $params = [
            'A' => 20,
            'B' => 40
        ];
        $method = 'GET';
        $result = $this->rpcxService->callRpcx($servicePath,$serviceMethod,$method,$params);
        return response()->json([
            'status' => 1,
            'data' => $result
        ]);
    }
}
