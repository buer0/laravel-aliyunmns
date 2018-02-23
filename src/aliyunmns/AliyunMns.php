<?php

namespace Buerxiaojie\AliyunMns;

use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Core\Config as AliyunConfig;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Core\Profile\DefaultProfile;
use Buerxiaojie\AliyunMns\Contracts\MNS;

/**
 *
 */
class AliyunMns implements MNS
{
    static $acsClient = null;

    protected function init()
    {
        /**
         * Step 1. 初始化Client
         */
        $this->endPoint  = config('aliyunmns.MnsEndpoint'); // eg. http://1234567890123456.mns.cn-shenzhen.aliyuncs.com
        $this->accessId  = config('aliyunmns.accessID');
        $this->accessKey = config('aliyunmns.accessKey');
        $this->client    = new Client($this->endPoint, $this->accessId, $this->accessKey);

        AliyunConfig::load();

    }

    public static function getAcsClient()
    {
        //产品名称:云通信流量服务API产品,开发者无需替换
        $product = "Dysmsapi";

        //产品域名,开发者无需替换
        $domain = "dysmsapi.aliyuncs.com";

        // TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
        $accessKeyId = $this->accessId; // AccessKeyId

        $accessKeySecret = $this->accessKey; // AccessKeySecret

        // 暂时不支持多Region
        $region = $this->endPoint;

        // 服务结点
        $endPointName = $this->endPoint;

        if (static::$acsClient == null) {

            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

            // 增加服务结点
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);
        }
        return static::$acsClient;
    }

    public function send($phoneNumber, $signName, $templateCode, array $templateParam = [], $outId = '', $upExtendCode = '')
    {
        $this->init();

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        // 必填，设置短信接收号码
        $request->setPhoneNumbers($phoneNumber);

        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $request->setSignName($signName);

        // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $request->setTemplateCode($templateCode);

        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
        $request->setTemplateParam(json_encode($templateParam, JSON_UNESCAPED_UNICODE));

        // 可选，设置流水号
        if ($outId) {
            $request->setOutId($outId);
        }

        // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
        if ($upExtendCode) {
            $request->setSmsUpExtendCode($upExtendCode);
        }

        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);

        return $acsResponse;
    }
}
