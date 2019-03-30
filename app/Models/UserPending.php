<?php

namespace App\Models;

use App\Http\Requests\UserRegisterRequest;
use Illuminate\Database\Eloquent\Model;
use Hash;

class UserPending extends Model
{
    protected $table = "panel_user_pendings";
    protected $fillable = [
        'name',
        'nickname',
        'login',
        'email',
        'password',
        'code',
        'resend_times',
        'enable',
    ];

    /**
     * Create a pending user model
     *
     * @param UserRegisterRequest $request
     */
    public static function createPendingUserFromRequest(UserRegisterRequest $request)
    {
        return self::create([
            'login' => strtolower($request->login),
            'name' => $request->truename,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make(strtolower($request->login) . $request->password),
            'code' => md5($request->login . time() . mt_rand(1, 99999) . $request->password),
            'enable' => false,
        ]);
    }
}
