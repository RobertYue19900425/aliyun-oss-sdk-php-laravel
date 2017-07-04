<?php namespace AliyunOss\Laravel\Test;

use AliyunOss\Laravel\AliyunOssFacade as AliyunOss;
use AliyunOss\Laravel\AliyunOssServiceProvider;
use Illuminate\Container\Container;

abstract class AliyunOssServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    public function testFacadeCanBeResolvedToServiceInstance()
    {
        $app = $this->setupApplication();
        $this->setupServiceProvider($app);

        // Mount facades
        AliyuOss::setFacadeApplication($app);

        // Get an instance of a oss client via the facade.
        $s3 = AliyunOss::OssClient();
        $this->assertInstanceOf('Oss\OssClient', $s3);
    }

    public function testRegisterAwsServiceProviderWithPackageConfigAndEnv()
    {
        $app = $this->setupApplication();
        $this->setupServiceProvider($app);

        // Get an instance of a oss client.
        /** @var $oss \Oss\OssClient */
        $oss = $app['aliyun-oss']->OssClient();
        $this->assertInstanceOf('Oss\OssClient', $oss);

        // Verify that the client received the credentials from the package config.
        $credentials = $oss->getOssClient();
        $this->assertEquals('foo', $credentials->getAccessKeyId());
        $this->assertEquals('bar', $credentials->getSecretKey());
        $this->assertEquals('baz', $s3->getRegion());
    }

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

        $this->assertArrayHasKey('ua_append', $config);
        $this->assertInternalType('array', $config['ua_append']);
        $this->assertNotEmpty($config['ua_append']);
        $this->assertNotEmpty(array_filter($config['ua_append'], function ($ua) {
            return false !== strpos($ua, AwsServiceProvider::VERSION);
        }));
    }

    /**
     * @return Container
     */
    abstract protected function setupApplication();

    /**
     * @param Container $app
     *
     * @return AwsServiceProvider
     */
    private function setupServiceProvider(Container $app)
    {
        // Create and register the provider.
        $provider = new AwsServiceProvider($app);
        $app->register($provider);
        $provider->boot();

        return $provider;
    }
}
