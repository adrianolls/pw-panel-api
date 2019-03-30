<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Controllers\Controller;
use App\Models\UserPending;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $userPending = UserPending::createPendingUserFromRequest($request);
        if (!config('perfectworld.mailactivateuser', true)) {
            return $this->checkUpAndCreateUser($userPending);
        }
        return response()->json(['message' => 'activate your account in email'], 200);
    }


    public function activateUser($code)
    {
        $userPending = UserPending::whereCode($code)->first();
        if (is_null($userPending)) {
            $result = [
                'error' => [
                    'invalidcode' => trans('custom.invalidcode')
                ]
            ];
            return response()->json($result, 422);
        }
        return $this->checkUpAndCreateUser($userPending);
    }

    /**
     * Check if UserPending is not invalid registration and create user
     */
    public function checkUpAndCreateUser(UserPending $userPending)
    {
        $usercheck = User::whereEmail($userPending->email)->first();
        if (!is_null($usercheck)) {
            return response()->json([
                'error' => [
                    'emailinuse' => trans('custom.emailinuse')
                ]
            ], 422);
        }
        $user = User::adduser($userPending);
        return $user;
    }
}
