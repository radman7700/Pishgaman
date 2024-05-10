<?php

namespace Pishgaman\Pishgaman\Database\Models\Department;

use Illuminate\Database\Eloquent\Model;
use Pishgaman\Pishgaman\Database\Models\User\User;

class DepartmentUser extends Model
{
    protected $table = 'department_users';
    protected $fillable = ['user_id','department_id','job_position'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
