<?php
namespace Mrlaozhou\WsChat\Entities;

use Mrlaozhou\WsChat\Contracts\Client\Client;
use Mrlaozhou\WsChat\Contracts\Connection\Connection;

class WsConnection
{

    /**
     * @var \Mrlaozhou\WsChat\Entities\WsClient
     */
    protected $CLIENT;

    public function __construct(WsClient $wsClient)
    {
        $this->setClient( $wsClient );
    }

    /**
     * @param \swoole_websocket_server $server
     * @param \swoole_http_request     $request
     *
     * @return bool|mixed
     */
    public function connect(\swoole_websocket_server $server, \swoole_http_request $request)
    {
        //  验证
        if( $this->client()->needAuth() ) {
            return $this->validateCertificate( $this->certificate( $request ) );
        }
        return true;
    }

    /**
     * @param string $certificate
     *
     * @return bool|mixed
     */
    public function validateCertificate(string $certificate)
    {
        //  请求客户端
        $httpClient                 =   new \GuzzleHttp\Client();
        //  请求地址
        $requestUrl                 =   $this->client()->payload('domain') . $this->client()->payload('user_api');
        $result                     =   $httpClient->get($requestUrl, [
            'headers'           =>  [
                'Authorization'     =>  'Bearer ' . $certificate,
            ]
        ]);
        if( ($result->getStatusCode() == 200) && ( $apiResult = json_decode( $result->getBody() ) ) && ($apiResult->code == 0) ) {
            $this->client()->setClientUserInfo( $apiResult->data );
            return $apiResult->data;
        }
        return false;
    }

    /**
     * @param \swoole_http_request $request
     *
     * @return string|mixed
     */
    public function certificate(\swoole_http_request $request)
    {
        return $request->cookie[ $this->client()->payload('auth_key') ];
    }

    /**
     * @return \Mrlaozhou\WsChat\Entities\WsClient
     */
    public function client()
    {
        return $this->CLIENT;
    }

    /**
     * @param \Mrlaozhou\WsChat\Entities\WsClient $client
     *
     * @return \Mrlaozhou\WsChat\Entities\WsClient
     */
    protected function setClient(WsClient $client)
    {
        return $this->CLIENT = $client;
    }
}