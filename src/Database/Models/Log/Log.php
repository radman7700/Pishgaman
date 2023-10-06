<?php

namespace Pishgaman\Pishgaman\Database\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pishgaman\Pishgaman\Database\Models\User\User;

class Log extends Model
{
    use HasFactory;

    // نام جدول مرتبط با مدل
    protected $table = 'logs';

    // فیلدهای قابل نوشتن (fillable) مدل
    protected $fillable = ['message', 'description', 'executed', 'is_accessible', 'user_id', 'ip'];

    // فیلدهای تاریخی که به صورت تاریخ (Carbon instance) در دسترس هستند
    protected $dates = ['created_at', 'updated_at'];

    // تعریف رابطه با مدل User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
