<?php
namespace Mrlaozhou\WsChat\Entities;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table            =   'messages';

    /**
     * @param int    $listen_pk
     * @param string $listen_role
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function unreadMessage(int $listen_pk, string $listen_role)
    {
        return static::query()
                     ->select('id', 'say_fd', 'say_fd', 'say_role', 'listen_fd', 'listen_pk', 'listen_role', 'type', 'text', 'file', 'say_at', 'listen_at')
                     ->where([
                         ['listen_pk', '=', $listen_pk],
                         ['listen_role', '=', $listen_role],
                         ['listen_at', '=', 0]
                     ])
                     ->get();
    }
}