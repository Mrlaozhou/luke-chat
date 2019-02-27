<?php
namespace Mrlaozhou\WsChat\Entities;

use Illuminate\Support\Str;
use Mrlaozhou\WsChat\Contracts\Client\Client;
use Mrlaozhou\WsChat\Contracts\Connection\Connection;
use Mrlaozhou\WsChat\Concerns\Package;

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
     * @return bool
     */
    public function validateCertificate(string $certificate)
    {
        if( ! $certificate )
            return false;
        //  请求客户端
        $httpClient                 =   new \GuzzleHttp\Client();
        //  请求地址
        $requestUrl                 =   $this->client()->payload('domain') . $this->client()->payload('user_api');

        $result                     =   $httpClient->request( $this->client()->payload('auth_type'), $requestUrl, [
            'headers'           =>  [
                $this->client()->payload('auth_key')     =>  'Bearer ' . $certificate,
                "Content-Type"=>"application/x-www-form-urlencoded",
                "x-requested-with"=>"XMLHttpRequest"
            ]
        ]);
        if( ($result->getStatusCode() == 200) && ( $apiResult = Package::decode( $result->getBody() ) ) && ($apiResult->code == 0) ) {
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
        return $request->header[ $auth_key = Str::lower( $this->client()->payload('auth_key') ) ] ?? ( $request->cookie[ $auth_key ] ?? '' );
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