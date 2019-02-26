<?php
namespace Mrlaozhou\WsChat\Entities;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Mrlaozhou\WsChat\Concerns\Package;

class WsMessage extends Model
{
    /**
     * @var \swoole_websocket_server
     */
    protected $SERVER;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $received;

    /**
     * @var \Mrlaozhou\WsChat\Entities\WsUser
     */
    protected $WsUser;

    /**
     * @var string
     */
    protected $table        =   'messages';

    protected $guarded      =   [

    ];

    public $timestamps      =   false;

    /**
     * WsMessage constructor.
     *
     * @param \swoole_websocket_server $server
     * @param \swoole_websocket_frame  $frame
     */
    public function __construct( \swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {
        //  设置客户端用户
        $this->setUser($frame->fd);
        //  设置swoole服务
        $this->SERVER   =   $server;
        //  解析收到的消息
        $this->receive($frame->data);

        parent::__construct();
    }

    /**
     * @return bool
     */
    public function pushToClient()
    {
        //  接收方是否在线
        if( $this->listener() ) {
            //  存储信息
            $this->storage();
            //  推送至客户端
            return $this->server()->push( $this->payload('to'), $this->encodeMessage() );
        } else {
            //  系统返回不在线提示
            return $this->server()->push( $this->WsUser->getKey(), $this->encodeMessage([
                'type'      =>  'system',
                'from'      =>  'system',
                'to'        =>  $this->WsUser->getKey(),
                'at'        =>  time(),
                'content'   =>  'offline',
            ]) );
        }
    }

    /**
     * @param null $package
     *
     * @return string
     */
    public function encodeMessage($package=null)
    {
        return Package::encode(
            is_null($package)
                ?   [
                'type'          =>  'message',
                'from'          =>  $this->WsUser->getKey(),
                'to'            =>  $this->payload('to'),
                'at'            =>  time(),
                'file'          =>  $this->payload('file'),
                'content'       =>  $this->payload('content')
            ]
                :   $package
        );
    }

    /**
     * @param string $receive
     *
     * @return \Illuminate\Support\Collection
     */
    public function receive(string $receive)
    {
        if( is_string($receive) && ($received = json_decode( $receive, true )) ) {
            $received       =   collect( $received );
        } else if( $receive instanceof Arrayable) {
            $received       =   collect( (array)$receive );
        } else {
            $received       =   collect( [] );
        }
        return $this->received  =   $received;
    }

    /**
     * @return \Mrlaozhou\WsChat\Entities\WsUser
     */
    public function sayer()
    {
        return $this->WsUser;
    }

    /**
     * @return \Mrlaozhou\WsChat\Entities\WsUser|null
     */
    public function listener()
    {
        return WsUser::find( (int)$this->payload('to') );
    }

    /**
     * @return static|Model|bool
     */
    public function storage()
    {
        $sayer              =   $this->sayer();
        $listener           =   $this->listener();
        return $this->setRawAttributes( [
            'say_fd'            =>  $sayer->getKey(),
            'say_pk'            =>  $sayer->pk,
            'say_role'          =>  $sayer->role(),
            'listen_fd'         =>  $listener->getKey(),
            'listen_pk'         =>  $listener->pk,
            'listen_role'       =>  $listener->role(),
            'type'              =>  $this->payload('type'),
            'text'              =>  $this->payload('content'),
            'file'              =>  $this->payload('file'),
            'say_at'            =>  time(),
            'listen_at'         =>  time(),
        ] )->save();
    }

    /**
     * @return \swoole_websocket_server
     */
    public function server()
    {
        return $this->SERVER;
    }

    /**
     * @param int $fd
     *
     * @return \Mrlaozhou\WsChat\Entities\WsUser
     */
    protected function setUser(int $fd)
    {
        return $this->WsUser    =   WsUser::find($fd);
    }

    /**
     * @param string|null $name
     *
     * @return \Illuminate\Support\Collection|mixed
     */
    protected function payload(string $name = null)
    {
        return is_null( $name )
            ?   $this->received
            :   $this->received->get($name, '');
    }
}