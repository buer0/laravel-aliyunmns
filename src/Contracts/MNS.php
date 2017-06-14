<?php
namespace Buer\AliyunMns\Contracts;

interface MNS
{
    public function send($phoneNumber, $signName, $templateCode, array $templateParam = []);
}