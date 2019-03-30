<?php

namespace App\Http\Requests;



class UserRegisterRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'required|min:4|max:12|alpha_dash|unique:users,name|unique:panel_user_pendings,login',
            'truename' => 'required|min:4|max:32',
            'email' => 'required|email|max:32|unique:users|unique:panel_user_pendings',
            'nickname' => 'required|min:4|max:16',
            'password' => 'required|min:8|max:16|regex:/[a-zA-Z0-9\#\@\!]$/',
            'repassword' => 'required|same:password',
            'terms' => 'accepted',
            //  'g-recaptcha-response' => 'required|captcha' //Disable on local test
        ];
    }
}
