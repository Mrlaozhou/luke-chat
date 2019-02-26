<?php
namespace Mrlaozhou\WsChat\Exceptions;

use Throwable;

class WsException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}