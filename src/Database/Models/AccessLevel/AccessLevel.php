<?php

namespace Pishgaman\Pishgaman\Database\Models\AccessLevel;

use Illuminate\Database\Eloquent\Model;

class AccessLevel extends Model
{
    protected $table = 'access_levels';
    protected $fillable = ['name'];
    
}
