<?php 

namespace Pishgaman\Pishgaman\Database\Models\Theme;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'templates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'type', 'active'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
