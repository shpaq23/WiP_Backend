<?php

namespace App;

use App\Http\Requests\Request;
use App\Http\Requests\User\Edit;
use App\Models\Uuid;
use DateTimeInterface;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Uuid;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name',
        'description', 'specialization_field_1', 'specialization_field_2', 'checkbox',
        'position', 'last_activity', 'email_verified_at', 'token', 'active', 'uuid', 'deleted', 'is_admin',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime:Y-m-d H:00',
        'last_activity' => 'datetime:Y-m-d H:00',
        'updated_at' => 'datetime:Y-m-d H:00',
        'created_at' =>'datetime:Y-m-d H:00'
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
        return User::where([
            'token' => $token,
            'deleted' => false,
            'active' => $verified
        ])->first();

    }
    static function getUserByEmail($email, $verified = true): ?User
    {
        return User::where([
            'email' => $email,
            'deleted' => false,
            'active' => $verified
        ])->first();
    }
    static function getUserByUuid($uuid, $verified = true, $for_admin = false): ?User
    {
        if ($for_admin) {
            return User::where([
                'uuid' => $uuid,
            ])->first();
        }
        return User::where([
            'uuid' => $uuid,
            'active' => $verified
        ])->first();
    }
    static function updateUser(Edit $edit): User
    {
        $user = User::where(['uuid' => $edit->uuid])->first();
        $user->update($edit->all());
        return $user->refresh();
    }
    public function activate($byAdmin = false)
    {
        $this->token = null;
        $this->email_verified_at = !$byAdmin ? now() : null;
        $this->active = true;
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
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
    public function updateActivity()
    {
        $this->last_activity = now();
        $this->save();
    }
    public function setAdmin()
    {
        $this->is_admin= 1;
        $this->save();
    }
    public function delete()
    {
        $this->deleted = true;
        $this->deleted_at = now();
        $this->save();
    }
    public function restore()
    {
        $this->deleted = false;
        $this->deleted_at = null;
        $this->save();
    }
    public function logout()
    {
        foreach ($this->tokens as $token) {
            $token->delete();
        }
    }
    public function getPretty($forAdmin = false): array
    {

        $arr = [
            'uuid' => $this->uuid,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'description' => $this->description,
            'position' => $this->position,
            'specializationField1' => $this->specialization_field_1,
            'specializationField2' => $this->specialization_field_2,
            'checkbox' => $this->checkbox,
            'isAdmin' => $this->is_admin,
        ];
        if ($forAdmin) {
            $arr['lastActivity'] = $this->last_activity? $this->last_activity->toDateTimeString(): null;
            $arr['activated'] = $this->active;
            $arr['deleted'] = $this->deleted;
        }
        return $arr;
    }

}
