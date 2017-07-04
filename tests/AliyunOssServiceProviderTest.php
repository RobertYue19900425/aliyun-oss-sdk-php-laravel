<?php namespace AliyunOss\Laravel\Test;

use AliyunOss\Laravel\AliyunOssFacade as AliyunOss;
use AliyunOss\Laravel\AliyunOssServiceProvider;
use Illuminate\Container\Container;

abstract class AliyunOssServiceProviderTest extends \PHPUnit_Framework_TestCase
{
//    public function testRegisterAliyunsOssServiceProviderWithPackageConfigAndEnv()
//    {
//        $app = $this->setupApplication();
//        $this->setupServiceProvider($app);

        // Get an instance of a oss client.
        /** @var $oss \Oss\OssClient */
//        $oss = $app['aliyun-oss']->listBuckets();
 //       $this->assertInstanceOf('OSS\OssClient', $oss);

        // Verify that the client received the credentials from the package config.
/*        $credentials = $oss->getOssClient();
        $this->assertEquals('foo', $credentials->getAccessKeyId());
        $this->assertEquals('bar', $credentials->getSecretKey());
        $this->assertEquals('baz', $oss->getRegion());
    }
*/
    public function testServiceNameIsProvided()
    {
        $app = $this->setupApplication();
        $provider = $this->setupServiceProvider($app);
        $this->assertContains('aliyun-oss', $provider->provides());
    }

    public function testVersionInformationIsProvidedToSdkUserAgent()
    {
        $app = $this->setupApplication();
        $this->setupServiceProvider($app);
        $config = $app['config']->get('aliyun-oss');

        $this->assertEquals('oss', $config['id']);
        $this->assertEquals('xxx', $config['key']);
        $this->assertEquals('oss-hangzhou', $config['endpoint']);
        $this->assertEquals('oss-bucket', $config['bucket']);
    }

    /**
     * @return Container
     */
    abstract protected function setupApplication();

    /**
     * @param Container $app
     *
     * @return AliyusOssServiceProvider
     */
    private function setupServiceProvider(Container $app)
    {
        // Create and register the provider.
        $provider = new AliyunOssServiceProvider($app);
        $app->register($provider);
        $provider->boot();

        return $provider;
    }
}
