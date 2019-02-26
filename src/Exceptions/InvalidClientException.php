<?php
namespace Mrlaozhou\WsChat\Exceptions;

use Illuminate\Http\Request;

class InvalidClientException extends WsException
{
    public function render(Request $request)
    {
        return [
            'error'         =>  '无效的客户端',
        ];
    }
}