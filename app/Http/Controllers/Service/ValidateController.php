<?php

/**
 * File: AliSMS.php
 * Description: 无
 * User: Alan
 * Datetime: 2017/5/23 23:08
 * Copyright Copyright(c) 2017
 * Version 1.0
 */

namespace App\Http\Controllers\Service;

use Illuminate\Support\Facades\Cache;


class ValidateController
{
    public function sendSMS()
    {
        $phone='13529595970';
        $cache_key = 'sign_up_' . $phone;
        $cache_phone = Cache::get($cache_key);
        if ($cache_phone == null) {
            //生成短信验证码
            $code = mt_rand(100000, 999999);
            //引入阿里大于SDK
            require app_path() . DIRECTORY_SEPARATOR . 'Tool' . DIRECTORY_SEPARATOR . 'alidayu' . DIRECTORY_SEPARATOR . 'TopSdk.php';
            $c = new \TopClient;
            $c->appkey = '23863458';
            $c->secretKey = 'ef46f0388932ca695d836614ed0e36e8';
            $req = new \AlibabaAliqinFcSmsNumSendRequest;
            //$req->setExtend("123456");
            $req->setSmsType("normal");
            $req->setSmsFreeSignName("验证码");
            $req->setSmsParam("{\"name\":\"【边城】用户\",\"code\":\"" . $code . "\"}");
            $req->setRecNum($phone);
            $req->setSmsTemplateCode("SMS_68180394");
            $resp = $c->execute($req);
            //将对象转为数组
            $arr_resp = json_decode(json_encode($resp), true);
            //发送成功
            if (isset($arr_resp['result']['err_code']) && $arr_resp['result']['err_code'] == '0') {
                //将验证码写入缓存，有效期15分钟
                $cache_key = 'sign_up_' . $phone;
                $cache_value = $code;
                Cache::put($cache_key, $cache_value, '15');
                return '发送成功';
            } else {
                //写入日志
                return $arr_resp['sub_msg'];
            }
        } else {
            //验证码还未过期
        }

        //if ($request->has('phone')) {
        //    $phone = $request->input('phone');
        //    $cache_key = 'sign_up_' . $phone;
        //    $cache_phone = Cache::get($cache_key);
        //    //exit(var_dump($cache_phone));
        //    if ($cache_phone == null) {
        //        //生成短信验证码
        //        $code = mt_rand(100000, 999999);
        //        //引入阿里大于SDK
        //        require app_path() . DIRECTORY_SEPARATOR . 'Tool' . DIRECTORY_SEPARATOR . 'alidayu' . DIRECTORY_SEPARATOR . 'TopSdk.php';
        //        $c = new \TopClient;
        //        $c->appkey = '23863458';
        //        $c->secretKey = 'ef46f0388932ca695d836614ed0e36e8';
        //        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        //        //$req->setExtend("123456");
        //        $req->setSmsType("normal");
        //        $req->setSmsFreeSignName("验证码");
        //        $req->setSmsParam("{\"name\":\"边城\",\"code\":\"" . $code . "\"}");
        //        $req->setRecNum($phone);
        //        $req->setSmsTemplateCode("SMS_68180394");
        //        $resp = $c->execute($req);
        //        //将对象转为数组
        //        $arr_resp = json_decode(json_encode($resp), true);
        //        //发送成功
        //        if (isset($arr_resp['result']['err_code']) && $arr_resp['result']['err_code'] == '0') {
        //            //将验证码写入缓存，有效期15分钟
        //            $cache_key = 'sign_up_' . $phone;
        //            $cache_value = $code;
        //            Cache::put($cache_key, $cache_value, '15');
        //            return '发送成功';
        //        } else {
        //            //写入日志
        //            return $arr_resp['sub_msg'];
        //        }
        //    } else {
        //        //验证码还未过期
        //    }
        //
        //}else{
        //    dd('手机号码不能为空！');
        //}


    }

}