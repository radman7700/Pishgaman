<?php

namespace Pishgaman\Pishgaman\Database\Models\AccessLevel;

use Illuminate\Database\Eloquent\Model;

class UserAccessLevel extends Model
{
    // نام جدول مرتبط با مدل
    protected $table = 'user_access_levels';

    // فیلدهای قابل تغییر
    protected $fillable = [
        'user_id',
        'access_level_id',
    ];

    // تعریف رابطه با جدول کاربران
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function AccessLevel()
    {
        return $this->belongsTo(AccessLevel::class, 'access_level_id');
    }
}
