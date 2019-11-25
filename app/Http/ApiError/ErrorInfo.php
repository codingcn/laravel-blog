<?php
/**
 * Created by PhpStorm.
 * User: Alan
 * Date: 2017/10/29
 * Time: 12:39
 */

namespace App\Http\ApiError;


trait ErrorInfo
{
    use ErrorMap;

    /**
     * 返回json格式响应
     * @param string $err_code
     * @param array $data
     * @param string $err_msg
     * @param int $status
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseJson($err_code = '', $data = [], $err_msg = '', $status = 200, array $headers = [], $options = 0)
    {
        if (isset(self::$err_map[$err_code])) {
            return response()->json([
                'err_no' => self::$err_map[$err_code]['err_no'],
                'err_code' => $err_code,
                'err_msg' => !empty($err_msg) ? $err_msg : self::$err_map[$err_code]['err_msg'],
                'data' => $data
            ], $status, $headers, $options);
        }
        return response()->json([
            'err_code' => $err_code,
            'err_msg' => 'undefined err_code.',
            'data' => $data
        ], 404, $headers, $options);
    }
}