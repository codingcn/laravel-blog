<?php
/**
 * Created by PhpStorm.
 * User: Alan
 * Date: 2017/11/15
 * Time: 22:29
 */

namespace App\Http\Controllers\Admin;


use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends CommonController
{
    /**
     * 返回网站设置
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $settings = Setting::all()->toArray();
        $res = [];
        foreach ($settings as $k => $v) {
            $res[$v['key']] = $v['value'];
        }
        $res['site_logo'] = \Storage::url($res['site_logo']);
        return $this->responseJson('OK', $res);
    }

    public function update(Request $request)
    {
        $data = $request->only([
                'site_title',
                'site_logo',
                'site_icp',
            ]
        );
        foreach ($data as $k => $v) {
            $setting = Setting::firstOrNew([
                'key' => $k,
            ]);
            if ($setting->key == 'site_logo') {
                $setting->value = preg_replace("/storage(\/.+)/m", '${1}', $v);
            } else {
                $setting->value = $v;
            }
            $setting->save();
        }
        return $this->responseJson('OK');
    }

    public function logoUpload(Request $request)
    {
        //提示：如果hasFile失败了，可能是服务器配置问题
        //需要排查以下设置：
        //1，upload_max_filesize
        //2，post_max_size
        //3，以及 upload_tmp_dir 的权限
        //等等关于上传文件的设置。
        if ($request->hasFile('site_logo')) {
            if ($request->file('site_logo')->isValid()) {
                $site_logo = $request->file('site_logo')->store('settings/site_logo/' . date('Y', time()) . '/' . date('md', time()));
                return $this->responseJson('OK', ['site_logo' => $site_logo]);
            } else {
                return responseApi(1, 'error');
            }
        } else {
            return $this->responseJson('INVALID_REQUEST');
        }
    }

    public function logoDestroy(Request $request)
    {
        if ($request->has('site_logo')) {
            $site_logo = preg_replace("/.+\/storage\/(.+)/m", '${1}', $request->input('site_logo'));
            $data = [
                $request->input('site_logo'),
                $site_logo,
                \Storage::url($site_logo)
            ];

            if (\Storage::delete($site_logo) === false) {
                return $this->responseJson('DELETE_FAIL', $data);
            }
            return $this->responseJson('OK', $data);
        } else {
            return $this->responseJson('INVALID_REQUEST');
        }
    }
}