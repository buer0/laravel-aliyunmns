<?php 
return [

	'accessID' => env('ALIYUN_ACCESS_ID'),

	'accessKey' => env('ALIYUN_ACCESS_KEY'),

	'MnsEndpoint' => env('ALIYUN_MNS_ENDPOINT'),

	'TopicName' => env('ALIYUN_MNS_TOPIC_NAME', 'sms.topic-cn-shenzhen'),
];