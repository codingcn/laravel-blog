<?php
/**
 * User: Alan
 * Date: 2017/10/29
 * Time: 12:33
 */

namespace App\Http\ApiError;


trait ErrorMap
{
    public static $err_map = [
        /**
         * 通用
         */
        'OK' => [
            'err_no' => 0,
            'err_msg' => '成功',
        ],
        'INVALID_REQUEST' => [
            'err_no' => 10000,
            'err_msg' => '参数校验失败',
        ],
        'INVALID_TOKEN' => [
            'err_no' => 10001,
            'err_msg' => 'token校验失败',
        ],
        'DELETE_FAIL' => [
            'err_no' => 20005,
            'err_msg' => '删除失败',
        ],
        'UPLOAD_FAIL' => [
            'err_no' => 20006,
            'err_msg' => '上传失败',
        ],



        /**
         * 第三方
         */
        'FAIL_SMS_SEND' => [
            'err_no' => 40001,
            'err_msg' => '验证码发送失败',
        ],
        'INVALID_SMS_CODE' => [
            'err_no' => 40002,
            'err_msg' => '验证码校验失败',
        ],
    ];
}