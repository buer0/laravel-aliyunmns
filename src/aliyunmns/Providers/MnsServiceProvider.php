<?php 
namespace Buerxiaojie\AliyunMns\Providers;

use Illuminate\Support\ServiceProvider;
use Buerxiaojie\AliyunMns\AliyunMns;

class MnsServiceProvider extends ServiceProvider
{
	public function boot()
	{
		/*
		* 生成配置文件
		*/
		$this->publishes([
			__DIR__ . '/../Config/MnsConfig.php' => config_path('aliyunmns.php'),
		]);
	}

	public function register()
	{
		$this->registerAliyunMnsBind();
		$this->registerAliyunMnsSingleton();
	}

	private function registerAliyunMnsBind()
	{
		$this->app->bind('AliyunMns\Contracts\MNS', function() {
			return new AliyunMns();
		});
	}

	private function registerAliyunMnsSingleton()
	{
		$this->app->singleton('aliyunmns', function() {
			return new AliyunMns();
		});
	}
}