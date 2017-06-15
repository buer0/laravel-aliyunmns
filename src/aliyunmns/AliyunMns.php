<?php 
namespace Buerxiaojie\AliyunMns;

use Buerxiaojie\AliyunMns\Contracts\MNS;
use AliyunMNS\Client;
use AliyunMNS\Topic;
use AliyunMNS\Constants;
use AliyunMNS\Model\MailAttributes;
use AliyunMNS\Model\SmsAttributes;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\PublishMessageRequest;

/**
* 
*/
class ClassName implements MNS
{
	protected function init()
	{
		/**
         * Step 1. 初始化Client
         */
        $this->endPoint = config('aliyunmns.MnsEndpoint'); // eg. http://1234567890123456.mns.cn-shenzhen.aliyuncs.com
        $this->accessId = config('aliyunmns.accessID');
        $this->accessKey = config('aliyunmns.accessKey');
        $this->client = new Client($this->endPoint, $this->accessId, $this->accessKey);

	}
	
	protected function getTopicRef($callback)
	{
		/**
         * Step 2. 获取主题引用
         */
        $this->resolveTopic($callback);
        return $this->client->getTopicRef($this->topicName);

	}

	protected function resolveTopic($callback) {
		if(is_callable($callback)) {
			$this->topicName = $callback;
		}else {
			$this->topicName = config('aliyunmns.topicName');
		}
	}

	protected function batchAttributes($phoneNumber, $signName, $templateCode, $templateParam = [])
	{
		/**
         * Step 3. 生成SMS消息属性
         */
        // 3.1 设置发送短信的签名（SMSSignName）和模板（SMSTemplateCode）
        $batchSmsAttributes = new BatchSmsAttributes($signName, $templateCode);
        // 3.2 （如果在短信模板中定义了参数）指定短信模板中对应参数的值
        $batchSmsAttributes->addReceiver($phoneNumber, $templateParam);

        $messageAttributes = new MessageAttributes(array($batchSmsAttributes));

        return $messageAttributes;
	}


	public function send($phoneNumber, $signName, $templateCode, array $templateParam = [], $callback = null)
	{
		$this->init();
        
        $topic = $this->getTopicRef($callback);

        $messageAttributes = $this->batchAttributes($phoneNumber, $signName, $templateCode, $templateParam);
        
        /**
         * Step 4. 设置SMS消息体（必须）
         *
         * 注：目前暂时不支持消息内容为空，需要指定消息内容，不为空即可。
         */
         $messageBody = "smsmessage";
        /**
         * Step 5. 发布SMS消息
         */
        $request = new PublishMessageRequest($messageBody, $messageAttributes);
        
        return $topic->publishMessage($request);
	}
}