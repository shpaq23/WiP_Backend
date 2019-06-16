<?php

namespace App;

use App\Http\Requests\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name',
        'description', 'specialization_field_1', 'specialization_field_2', 'checkbox',
        'position', 'last_activity', 'email_verified_at', 'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_activity' => 'datetime'
    ];

    static function newUser(Request $request): User
    {
        $request = $request->all();
        $request['name'] = $request['first_name'] . ' ' . $request['last_name'];
        $request['password'] = bcrypt($request['password']);
        $request['token'] = getSecureToken();
        $user = new User($request);
        $user->save();

        return $user;
    }

    static function getUserByToken($token, $verified = true): ?User
    {
        $user = User::where([
            'token' => $token,
        ]);
        if (!$verified) {
            $user->whereNull('email_verified_at');
        } else {
            $user->whereNotNull('email_verified_at');
        }
        return $user->first();

        return $user->first();
    }
    static function getUserByEmail($email, $verified = true): ?User
    {
        $user = User::where([
            'email' => $email,
        ]);
        if (!$verified) {
           $user->whereNull('email_verified_at');
        } else {
            $user->whereNotNull('email_verified_at');
        }
        return $user->first();
    }
    public function activate()
    {
        $this->token = null;
        $this->email_verified_at = now();
        $this->save();
    }
    public function setNewToken(): User
    {
        $this->token = getSecureToken();
        $this->save();

        return $this->refresh();
    }
    public function setNewPassword($password): User
    {
        $this->password = bcrypt($password);
        $this->token = null;
        $this->save();

        return $this->refresh();
    }
}
