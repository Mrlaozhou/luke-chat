<?php
namespace Mrlaozhou\WsChat\Contracts\Client;

interface Client
{

    /**
     * @param string|null $name
     *
     * @return mixed
     */
    public function payload(string $name=null);

    /**
     * @return string
     */
    public function type();

    /**
     * @return \Illuminate\Support\Collection|array|null
     */
    public function clients($clients = null);
}