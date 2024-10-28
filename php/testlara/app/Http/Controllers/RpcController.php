<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RpcController extends Controller
{
    public function test()
    {
        $host = "192.168.72.130";
        $port = '1234';
        // 建立连接
        $conn = fsockopen($host,$port,$errno,$errstr,3);
        if (!$conn) {
            dd('链接失败');
        }

        $method = 'Rect.Area';
        $params = [
            'Width' => 10,
            'Height' => 2
        ];
        $err = fwrite($conn,json_encode([
            'jsonrpc' => '2.0',
            'method' => $method,
            'params' => [$params],
            'id' => 0
        ])."\n");
        if ($err === false) {
            dd('写入数据失败');
        }
        stream_set_timeout($conn,0,30000);
        $line = fgets($conn);
        if ($line === false) {
            dd('获取响应数据失败');
        }
        dd(json_decode($line,true));
    }
}
