<?php

namespace Pishgaman\Pishgaman\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_path',
        'status',
        'read',
        'user_id'
    ];
}
