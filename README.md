# Aliyun Oss Service Provider for Laravel 5

## 安装laravel
```首先在composer.json中添加
{
    "require": {
        "aliyun-oss/aliyun-oss-php-sdk-laravel": "dev-master"
    }
}
然后执行
composer update
```

## 运行test case
```首先设置环境变量
export OSS_TEST_ENDPOINT=''                 
export OSS_TEST_ACCESS_KEY_ID=''              
export OSS_TEST_ACCESS_KEY_SECRET=''
export OSS_TEST_BUCKET=''

进入目录
php vendor/bin/phpunit
```

## For laravel
```
修改 config/app.php 并且register aliyunoss Service Provider.

    'providers' => array(
        // ...
        AliyunOss\Laravel\AliyunOssServiceProvider::class,
    )

Find the aliases key in your config/app.php and add the AWS facade alias.

    'aliases' => array(
        // ...
        'AWS' => Aws\Laravel\AwsFacade::class,
    )
```

