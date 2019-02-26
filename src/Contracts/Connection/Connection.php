<?php
namespace Mrlaozhou\WsChat\Contracts\Connection;

interface Connection
{
    /**
     * @return \Mrlaozhou\WsChat\Contracts\Client\Client
     */
    public function connect(\swoole_websocket_server $server, \swoole_http_request $request);

    /**
     * @param string $certificate
     *
     * @return mixed
     */
    public function validateCertificate(string $certificate);

    /**
     * @param \swoole_http_request $request
     *
     * @return mixed
     */
    public function certificate(\swoole_http_request $request);

    /**
     * @return \Mrlaozhou\WsChat\Contracts\Client\Client
     */
    public function client();
}