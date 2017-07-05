# Aliyun Oss Service Provider for Laravel 5

[![Build Status](https://travis-ci.org/RobertYue19900425/aliyun-oss-sdk-php-laravel.svg?branch=master)](https://travis-ci.org/RobertYue19900425/aliyun-oss-sdk-php-laravel)
[![Coverage Status](https://coveralls.io/repos/github/RobertYue19900425/aliyun-oss-sdk-php-laravel/badge.svg?branch=master)](https://coveralls.io/github/RobertYue19900425/aliyun-oss-sdk-php-laravel?branch=master)

## 安装laravel
```
1. 首先在composer.json中添加
{
    "require": {
        "aliyun-oss/aliyun-oss-php-sdk-laravel": "dev-master"
    }
}
2. 然后执行
composer update
```

## 运行test case
```
1. 首先设置环境变量
export OSS_TEST_ENDPOINT=''                 
export OSS_TEST_ACCESS_KEY_ID=''              
export OSS_TEST_ACCESS_KEY_SECRET=''
export OSS_TEST_BUCKET=''

2. 进入目录,执行
php vendor/bin/phpunit
```


## Usage For laravel
```
1. 修改vendor/aliyun-oss/aliyun-oss-php-sdk-laravel/config/config.php
return [
    'id' => 'your id',
    'key' => 'your key',
    'endpoint' => 'your endpoint',
    'bucket' => 'your bucket'
];

2. 修改 config/app.php 并且register aliyunoss Service Provider.

    'providers' => array(
        // ...
        AliyunOss\Laravel\AliyunOssServiceProvider::class,
    )

3. 在config/app.php 增加aliases.

    'aliases' => array(
        // ...
        'OSS' => AliyunOss\Laravel\AliyunOssFacade::class,
    )

4. 修改routes/web.php为

Route::get('/', function()
{
    $client = App::make('aliyun-oss');
    $client->putObject("your bucket", "your object", "content you want to upload");
    $result = $client->getObject("your bucket", "your boject");
    echo $result;
});
```
