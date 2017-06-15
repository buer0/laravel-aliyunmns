<?php 
return [

	'accessID' => env('ALIYUN_ACCESS_ID'),

	'accessKey' => env('ALIYUN_ACCESS_KEY'),

	'MnsEndpoint' => env('ALIYUN_MNS_ENDPOINT'),

	'topicName' => env('ALIYUN_MNS_TOPIC_NAME', 'sms.topic-cn-shenzhen'),
];