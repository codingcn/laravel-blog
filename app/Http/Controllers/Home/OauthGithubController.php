<?php

namespace App\Http\Controllers\Home;

use App\Models\OauthGithubUser;
use App\Models\User;
use GuzzleHttp\Client;

class OauthGithubController
{
    /**
     * 唤起登录
     * @return \Illuminate\Auth\Access\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function authorize()
    {
        $url = 'https://github.com/login/oauth/authorize?';
        $param = http_build_query([
            'client_id' => config('oauth.github.client_id'),
            'redirect_uri' => url('/oauth/github/callback'),
            'state' => str_random(16),
            'allow_signup' => true,
        ]);
        return redirect($url . $param);
    }

    /**
     * 登录回调
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function callback()
    {
        $http = new Client();
        $url = 'https://github.com/login/oauth/access_token?' . http_build_query([
                'client_id' => config('oauth.github.client_id'),
                'client_secret' => config('oauth.github.client_secret'),
                'code' => request('code'),
                'redirect_uri' => url('/oauth/github/callback'),
                'state' => request('state'),
            ]);
        $response = $http->request('post', $url, [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);
        $token_data = json_decode((string)$response->getBody(), true);
        if (!empty($token_data['access_token'])) {
            $url = 'https://api.github.com/user?access_token=' . $token_data['access_token'];
            $response = $http->request('get', $url, [
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]);
            $oauth_user_data = json_decode((string)$response->getBody(), true);
            if (!empty($oauth_user_data['login'])) {
                if ($this->findOrCreateUser($oauth_user_data)) {
                    return redirect(url('/'));
                } else {
                    return redirect(url('/oauth/github/authorize'));
                }
            } else {
                return redirect(url('/oauth/github/authorize'));
            }
        } else {
            return redirect(url('/oauth/github/authorize'));
        }
    }

    public function findOrCreateUser($oauth_user_data)
    {
        $user_data = [
            'username' => $oauth_user_data['login'],
            'email' => $oauth_user_data['email'],
            'avatar' => $oauth_user_data['avatar_url'],
            'password' => '',
        ];
        try {
            \DB::beginTransaction();
            $oauth_github_user = OauthGithubUser::where('login', $oauth_user_data['login'])->first(['user_id']);
            if ($oauth_github_user) {
                OauthGithubUser::where('login', $oauth_user_data['login'])->update($oauth_user_data);
                User::where('id', $oauth_github_user->user_id)->update($user_data);
                \Auth::guard('web')->loginUsingId($oauth_github_user->user_id);
            } else {
                $user = User::create($user_data);
                $oauth_user_data['user_id'] = $user->id;
                OauthGithubUser::create($oauth_user_data);
                \Auth::guard('web')->loginUsingId($user->id);
            }
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            var_dump($e);
            \DB::rollBack();
            return false;
        }
    }
}
