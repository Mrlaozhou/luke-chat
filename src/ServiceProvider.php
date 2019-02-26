<?php
namespace Mrlaozhou\WsChat;

use \Illuminate\Support\ServiceProvider as BaseServiceProvider;

abstract class ServiceProvider extends BaseServiceProvider
{

    /**
     * 注册数据库迁移
     */
    protected function registerMigration()
    {
        $this->loadMigrationsFrom([
            __DIR__ . '/../database/migrations/'
        ]);
    }

    /**
     * 注册合并文件
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/ws-chat.php', 'ws-chat'
        );
    }

    /**
     * 配置文件发布
     */
    protected function publishConfig()
    {
        $this->publishes( [
            __DIR__ . '/../config/ws-chat.php'  =>  config_path( 'ws-chat.php' )
        ], 'config' );
    }
}