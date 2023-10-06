<?php

namespace Pishgaman\Pishgaman\Database\Models\AccessLevel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    // اگر نیاز به تعریف روابط با دیگر مدل‌ها دارید، می‌توانید آن‌ها را در اینجا تعریف کنید.

}
