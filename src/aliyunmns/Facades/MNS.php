<?php
namespace Buerxiaojie\AliyunMns\Facades;

use Illuminate\Support\Facades\Facade;

class MNS extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'aliyunmns';
    }
}