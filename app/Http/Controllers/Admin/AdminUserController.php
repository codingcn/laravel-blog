<?php
/**
 * Created by PhpStorm.
 * User: Alan
 * Date: 2017/11/15
 * Time: 22:29
 */

namespace App\Http\Controllers\Admin;


use App\Models\AdminUser;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminUserController extends CommonController
{
    public function show()
    {
        $user = \Auth::guard('api')->user();
        if (preg_match('/^http/', $user->avatar) == false) {
            $user->avatar = \Storage::url($user->avatar);
        }
        return $this->responseJson('OK', $user);
    }

    public function update(Request $request)
    {
        $data = $request->only([
                'username',
                'phone',
                'email',
                'old_password',
                'new_password',
                'avatar'
            ]
        );
        $admin_user = \Auth::guard('api')->user();
        $admin_user->username = $data['username'];
        $admin_user->phone = $data['phone'];
        $admin_user->email = $data['email'];
        if (!empty($data['avatar'])) {
            $admin_user->avatar = preg_replace("/^http.*storage\/uploads\/(.*)/m", '${1}', $data['avatar']);
        }
        $data['change_password'] = 'no';
        if (!empty($data['old_password']) && !empty($data['new_password'])) {
            if (\Hash::check($data['old_password'], $admin_user->password)) {
                $admin_user->password = bcrypt($data['new_password']);
                $data['change_password'] = 'yes';
            }else{
                return $this->responseJson('INVALID_REQUEST', [],'原密码错误');
            }
        }
        $admin_user->save();
        return $this->responseJson('OK', $data);
    }

    public function avatarUpload(Request $request)
    {
        //提示：如果hasFile失败了，可能是服务器配置问题
        //需要排查以下设置：
        //1，upload_max_filesize
        //2，post_max_size
        //3，以及 upload_tmp_dir 的权限
        //等等关于上传文件的设置。
        if ($request->hasFile('avatar')) {
            if ($request->file('avatar')->isValid()) {
                $avatar = $request->file('avatar')->store('settings/avatar/' . date('Y', time()) . '/' . date('md', time()));
                return $this->responseJson('OK', ['avatar' => $avatar]);
            } else {
                return responseApi(1, 'error');
            }
        } else {
            return $this->responseJson('INVALID_REQUEST');
        }
    }

    public function avatarDestroy(Request $request)
    {
        if ($request->has('avatar')) {
            $avatar = preg_replace("/.+\/storage\/uploads\/(.+)/m", '${1}', $request->input('avatar'));
            $data = [
                $request->input('avatar'),
                $avatar,
            ];

            if (\Storage::delete($avatar) === false) {
                return $this->responseJson('DELETE_FAIL', $data);
            }
            return $this->responseJson('OK', $data);
        } else {
            return $this->responseJson('INVALID_REQUEST');
        }
    }
}