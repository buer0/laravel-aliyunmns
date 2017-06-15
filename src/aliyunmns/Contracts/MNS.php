<?php
namespace Buerxiaojie\AliyunMns\Contracts;

interface MNS
{
    public function send($phoneNumber, $signName, $templateCode, array $templateParam = []);
}