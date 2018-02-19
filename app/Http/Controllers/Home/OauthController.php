<?php

namespace App\Http\Controllers\Home;

use App\Models\OauthGithubUser;
use GuzzleHttp\Client;

class OauthController
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

    public function getAccessToken()
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
            $user_data = json_decode((string)$response->getBody(), true);
            if (!empty($user_data['login'])) {
                $this->findOrCreateUser($user_data);
            } else {
                return redirect(url('/oauth/github/authorize'));
            }
        } else {
            return redirect(url('/oauth/github/authorize'));
        }
    }

    public function findOrCreateUser($user_data)
    {
        $oauth_github_user = OauthGithubUser::updateOrCreate(
            ['login' => $user_data['login']],
            $user_data
        );
        dd($oauth_github_user);
    }
}
