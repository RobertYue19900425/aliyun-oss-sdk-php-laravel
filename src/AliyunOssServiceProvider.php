<?php namespace AliyunOss\Laravel;

use Oss\OssClient;
use OSS\Core\OssException;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

/**
 * AliyunOss SDK for PHP service provider for Laravel applications
 */
class AliyunOssServiceProvider extends ServiceProvider
{
    const VERSION = '3.1.0';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the configuration
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath(__DIR__ . '/../config/config.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('config.php')]);
        }
 
        $this->mergeConfigFrom($source, 'aliyun-oss');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('aliyun-oss', function ($app) {
            $config = $app->make('config')->get('aliyun-oss');

            return new OssClient($config);
        });

        $this->app->alias('aliyun-oss', 'Oss\OssClient');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['aliyun-oss', 'Oss\OssClient'];
    }

}
