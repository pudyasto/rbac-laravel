<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RoleHasMenus extends Model
{
    use HasFactory;
    use Notifiable;
    protected $table = 'role_has_menus';
    
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'role_id',
        'menu_uuid',
    ];

    protected $hidden = [];
}
