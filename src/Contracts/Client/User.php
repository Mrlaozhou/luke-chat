<?php
namespace Mrlaozhou\WsChat\Contracts\Client;

interface User
{

    /**
     * 是否活跃状态
     * @return bool
     */
    public function isActive();

    /**
     * @return mixed
     */
    public function online();

    /**
     * @return bool
     */
    public function outline();

    /**
     * @return int
     */
    public function fd();

    /**
     * 用户角色
     * @return string
     */
    public function role();

    /**
     * 用户模型
     * @return mixed
     */
    public function model();

    /**
     * 上线时间
     * @return \Illuminate\Support\Carbon
     */
    public function online_at();
}