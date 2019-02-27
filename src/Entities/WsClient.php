<?php
namespace Mrlaozhou\WsChat\Entities;


use Illuminate\Support\Arr;

class WsClient
{
    /**
     * @var string
     */
    protected $TYPE;

    /**
     * @var object
     */
    protected $USERINFO     =   [];

    public function __construct()
    {

    }

    /**
     * @return bool|null
     */
    public function needAuth()
    {
        return $this->payload( 'need_auth' );
    }

    /**
     * @param string|null $name
     *
     * @return \Illuminate\Support\Collection|mixed
     */
    public function payload(string $name = null)
    {
        $payload                =   $this->clients()->get( $this->type() );
        if( is_null($name) ) {
            return $payload;
        }
        return Arr::get( $payload, $name );
    }

    /**
     * @return mixed|null|string
     */
    public function type()
    {
        if( $this->TYPE ) {
            return $this->TYPE;
        }

        //  参数形式
        if( ($type = request()->get('type')) && $this->clients()->has($type) ) {
            return $this->TYPE = $type;
        }

        //  header形式
        if( ($type = request()->header('type')) && $this->clients()->has($type) ) {
            return $this->TYPE = $type;
        }

        //  请求来源
        if( $this->clients()->whereStrict('domain', $http_origin = request()->server('HTTP_ORIGIN') )->isNotEmpty() ) {
            return $this->TYPE = $this->clients()->pluck('name', 'domain')->get( $http_origin );
        }
        return $this->TYPE = 'member';
    }

    /**
     * @param int $fd
     *
     * @return \Mrlaozhou\WsChat\Entities\WsUser|\Illuminate\Database\Eloquent\Model
     */
    public function rememberClientUser(int $fd)
    {
        //  删除腐朽的
        WsUser::destroy( $fd );
        //  重新存储
        return WsUser::query()->create( [
            'fd'        =>  $fd,
            'role'      =>  $this->type(),
            'pk'        =>  $this->getClientUserInfo()->id ?? 0,
            'info'      =>  json_encode( $this->getClientUserInfo(), true ),
        ] );
    }

    /**
     * @return object
     */
    public function getClientUserInfo()
    {
        return $this->USERINFO;
    }

    /**
     * @param $userInfo
     *
     * @return array
     */
    public function setClientUserInfo($userInfo)
    {
        return $this->USERINFO  =   $userInfo;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function clients()
    {
        return collect( config('ws-chat.clients') );
    }
}