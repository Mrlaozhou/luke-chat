<?php
namespace Mrlaozhou\WsChat\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Mrlaozhou\WsChat\Entities\Message;
use Nexmo\Entity\JsonResponseTrait;
use Nexmo\Entity\JsonSerializableTrait;

class Package
{
    /**
     * @param array $data
     *
     * @return string
     */
    public static function encode(array $data)
    {
        return json_encode( $data, true );
    }

    /**
     * @param string $data
     * @param bool   $assoc
     *
     * @return mixed
     */
    public static function decode(string $data, $assoc = false)
    {
        return json_decode( $data, $assoc );
    }

    /**
     * @param \Mrlaozhou\WsChat\Entities\Message $message
     *
     * @return string
     */
    public static function messageEncode(Message $message)
    {
        return static::encode([
            'type'          =>  $message->type,
            'from'          =>  $message->say_fd,
            'to'            =>  $message->listen_fd,
            'at'            =>  $message->say_at,
            'content'       =>  $message->text,
            'file'          =>  $message->file,
        ]);
    }
}