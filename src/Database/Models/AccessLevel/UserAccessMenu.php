<?php

namespace Pishgaman\Pishgaman\Database\Models\AccessLevel;

use Illuminate\Database\Eloquent\Model;
use Pishgaman\Pishgaman\Database\Models\User\User;
class UserAccessMenu extends Model
{
    /**
     * نام جدول مربوط به مدل
     *
     * @var string
     */
    protected $table = 'user_access_menus';

    /**
     * نام فیلد کلید اصلی جدول
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * فیلدهای قابل انتخاب (fillable) جدول
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'menu_id',
    ];

    /**
     * ارتباط مدل UserAccessMenu با مدل User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * ارتباط مدل UserAccessMenu با مدل AcMenu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(AcMenu::class, 'menu_id');
    }
}
