<?php

namespace Pishgaman\Pishgaman\Database\Models\User;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\UserAccessLevel;
use Pishgaman\Pishgaman\Database\Models\AccessLevel\UserAccessMenu;
use Pishgaman\Pishgaman\Database\Models\Department\Department;
use Pishgaman\Pishgaman\Database\Models\Department\DepartmentUser;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'username',
        'email',
        'phone',
        'password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'email_verified_at',
        'phone_verified_at',
        'password_verified_at',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * Define the relationship between User model and UserAccessMenu model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAccessMenus()
    {
        return $this->hasMany(UserAccessMenu::class, 'user_id');
    }

    public function userAccessLevels()
    {
        return $this->belongsToMany(UserAccessLevel::class, 'user_access_menus', 'user_id', 'access_level_id');
    }    

    public function department_user()
    {
        return $this->hasMany(DepartmentUser::class, 'user_id');
    } 
}
