<?php
namespace Mrlaozhou\WsChat;

use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;
use Mrlaozhou\WsChat\Entities\WsClient;
use Mrlaozhou\WsChat\Entities\WsConnection;
use Mrlaozhou\WsChat\Entities\WsMessage;
use Mrlaozhou\WsChat\Entities\WsUser;

class WsChat implements WebSocketHandlerInterface
{

    public function __construct()
    {
    }

    /**
     * 客户端连接
     *
     * @param \swoole_websocket_server $server
     * @param \swoole_http_request     $request
     */
    public function onOpen(\swoole_websocket_server $server, \swoole_http_request $request)
    {
        //  初始化连接客户端
        $wsConnection = new WsConnection($wsClient = new WsClient());
        //  连接
        if ($clientUserInfo = $wsConnection->connect($server, $request)) {
            //  连接成功
            //  存储当前客户端用户
            $wsUser = $wsClient->rememberClientUser($request->fd);
            //  推送用户列表
            $server->push($request->fd, $this->encodeClientData( $wsUser->contactsList() ) );
            //  推送未读消息
            $wsUser->unreadMessage()->map(function ($item) use ($server, $request){
                $server->push( $request->fd, $this->encodeClientData( $item ) );
            });
        } else {
            //  连接失败
            $server->close($request->fd);
        }
    }

    /**
     * 消息处理
     *
     * @param \swoole_websocket_server $server
     * @param \swoole_websocket_frame  $frame
     */
    public function onMessage(\swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {
        $wsMessage = new WsMessage($server, $frame);
        $wsMessage->pushToClient();
    }

    /**
     * 客户端断开连接
     *
     * @param \swoole_websocket_server $server
     * @param                          $fd
     * @param                          $reactorId
     */
    public function onClose(\swoole_websocket_server $server, $fd, $reactorId)
    {
        //  删除当前客户端用户
        WsUser::destroy($fd);
    }

    /**
     * @param array $data
     *
     * @return string
     */
    protected function encodeClientData(array $data = [])
    {
        return json_encode( $data, true );
    }
}