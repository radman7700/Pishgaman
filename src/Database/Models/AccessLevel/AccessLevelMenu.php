<?php

namespace Pishgaman\Pishgaman\Database\Models\AccessLevel;

use Illuminate\Database\Eloquent\Model;
use Pishgaman\Pishgaman\Database\Models\User\User;

/**
 * Class AccessLevelMenu
 * @package App\Models
 *
 * @property int $id
 * @property int $access_level_id
 * @property int $menu_id
 *
 * @property AccessLevel $accessLevel
 * @property Menu $menu
 */
class AccessLevelMenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'access_level_menu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'access_level_id',
        'menu_id',
    ];

    /**
     * Get the access level that this menu belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accessLevel()
    {
        return $this->belongsTo(AccessLevel::class, 'access_level_id');
    }

    /**
     * Get the menu that this access level belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }    
}
