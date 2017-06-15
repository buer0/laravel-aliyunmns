# 阿里云短信服务

## （一）安装

### 1. 安装：


```php
composer require buerxiaojie/laravel-aliyunmns
```

### 2. 注册：


在 `config/app.php` 文件的 `providers` 数组中加入：

```php
  Buerxiaojie\AliyunMns\Providers\MnsServiceProvider::class,
```


在 `config/app.php` 文件的 `aliases` 数组中加入：

```php
  'MNS' => Buerxiaojie\AliyunMns\Facades\MNS::class,
```


### 3. 生成配置文件：


```php
  php artisan vendor:publish
```


## （二）配置

在 `.env` 文件中加入以下，它们的值从阿里云的 `控制台` 获取：

```php
  /**
   * 加入以下
   * 
   */
   
  ALIYUN_ACCESS_ID=
  ALIYUN_ACCESS_SECRET=
  ALIYUN_MNS_ENDPOINT=
  ALIYUN_MNS_TOPIC_NAME=
 
```

## （三）使用


手机号码、短信签名、短信模板是 `字符串`，模板参数是数组的 `键值对`：

```php
  /**
   * 导入
   *
   */
   
  use MNS;
  
  /**
   * 使用
   *
   */
   
  MNS::send("手机号码", "短信签名", "短信模板", ["模板参数的键" => "模板参数的值"]);
  
  // 切换topic时
  MNS::send("手机号码", "短信签名", "短信模板", ["模板参数的键" => "模板参数的值"], function() {
  	return "NEW TOPIC NAME";
  });
 
```
