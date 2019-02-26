<?php
namespace Mrlaozhou\WsChat\Concerns;

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
}