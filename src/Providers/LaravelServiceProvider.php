<?php
namespace Mrlaozhou\WsChat\Providers;

use Mrlaozhou\WsChat\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        //  注册migrations
        $this->registerMigration();

        //  注册配置
        $this->registerConfig();
    }
}