<?php 

namespace Pishgaman\Pishgaman\Repositories;

use Illuminate\Support\Facades\Auth;
use Request;
use Pishgaman\Pishgaman\Database\Models\Log\Log;

class LogRepository
{
    public function createLog($message, $executed = false, $isAccessible = false)
    {
        // دریافت شناسه کاربر و آدرس IP فعلی
        $userId = Auth::id();
        $ip = Request::ip();

        // ایجاد رکورد جدید با استفاده از مدل Log
        return Log::create([
            'message' => $message,
            'executed' => $executed,
            'is_accessible' => $isAccessible,
            'user_id' => $userId ?? null,
            'ip' => $ip,
        ]);
    }
    public function updateLog($message,$id)
    {
        return Log::where('id',$id)->update(['description'=>$message]);
    }
}
