<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Hash;
use DB;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $primaryKey = 'ID';
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'passwd', 'passwd2', 'prompt', 'answer', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Override default password acquire method
     *
     * @return null|string
     */
    public function getAuthPassword()
    {
        return self::acquireUserPasswd($this->name);
    }

    /**
     * Retrieve user password from database
     *
     * @param $login
     * @return null
     */
    public static function acquireUserPasswd($login)
    {
        DB::update("call acquireuserpasswd(?,@id,@passwd)", [$login]);
        $results = DB::select('select @id as id, @passwd as passwd');
        return ($results[0]->passwd) ? $results[0]->passwd : null;
    }

    /**
     * Add Gold Currency of perfect world on model, do not require multiply by 100
     *
     * @param $quantity
     */
    public function addCash($quantity)
    {
        DB::update("call usecash (?,1,0,?,0,?,1,@error);", [
            $this->ID,
            intval(1),
            intval($quantity) * 100
        ]);
    }

    /**
     * Register a New User using UserPendent Model
     *
     * @param UserPending $user
     * @return User
     */
    public static function adduser(UserPending $user)
    {
        switch (config('perfectworld.hash', 'binsalt')) {
            case 'binsalt':
                DB::update("call adduser (?," . $user->password . ",?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);", [
                    $user->login,
                    0,
                    0,
                    $user->name,
                    $user->nickname,
                    $user->email,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    $user->password
                ]);
                break;
            default:
                DB::update("call adduser (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);", [
                    $user->login,
                    $user->password,
                    0,
                    0,
                    $user->name,
                    $user->nickname,
                    $user->email,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    $user->password
                ]);
                break;
        }
        $useracc = self::where('name', $user->login)->first();

        $observer = new UserObserver();
        $observer->created($useracc);
        $user->delete();
        return $useracc;
    }

//    public function has_role($roleid)
//    {
//        /**
//         * Role Owner Validation
//         */
//        $roles_array = PW::getRoleList($this->ID);
//        $valid_role = false;
//        foreach ($roles_array->users as $role)
//        {
//            if ($role->roleid === intval($roleid))
//            {
//                $valid_role = true;
//                break;
//            }
//        }
//        return $valid_role;
//    }


    /**
     * Overrides the method to ignore the remember token.
     */
    public function getRememberToken()
    {
        return null;
    }

    /**
     * Overrides the method to ignore the remember token.
     */
    public function setRememberToken($value)
    {
        return $value;
    }

    /**
     * Overrides the method to ignore the remember token.
     */
    public function getRememberTokenName()
    {
        return null;
    }

    /**
     * Overrides the method to ignore the remember token.
     */
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute) {
            parent::setAttribute($key, $value);
        }
    }

}
