<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends CommonController
{
    public function index()
    {
        $res = User::select(['id', 'username', 'email', 'phone', 'created_at'])->paginate(1);
        return $this->responseJson('OK', $res);
    }

    public function search(Request $request)
    {
        if ($request->has('keywords')) {
            $keywords = $request->input('keywords');
            $res = User::select(['id', 'username', 'email', 'phone', 'created_at'])
                ->where('username', 'like', "%{$keywords}%")
                ->orWhere('phone', 'like', "%{$keywords}%")
                ->orWhere('email', 'like', "%{$keywords}%")
                ->paginate(1);
            return $this->responseJson('OK', $res);
        }
    }
}
