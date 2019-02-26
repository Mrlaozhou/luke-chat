<?php
namespace Mrlaozhou\WsChat\Contracts\Message;

interface Message
{
    /**
     * @param array $receive
     *
     * @return self
     */
    public static function receive( array $receive );

    /**
     * @return \Mrlaozhou\WsChat\Contracts\Client\User
     */
    public function say();

    /**
     * @return \Mrlaozhou\WsChat\Contracts\Client\User
     */
    public function listen();

    /**
     * @return null|string
     */
    public function text();

    /**
     * @return string|null
     */
    public function file();

    /**
     * @return null|\Illuminate\Support\Carbon
     */
    public function say_at();

    /**
     * @return null|\Illuminate\Support\Carbon
     */
    public function listen_at();

    /**
     * @return mixed
     */
    public function storage();
}