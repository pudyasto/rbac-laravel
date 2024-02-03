<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Menus extends Model
{
    use HasFactory;
    use Uuid;
    // use Notifiable, SoftDeletes;
    //
    protected $table = 'menus';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'menu_order',
        'menu_header',
        'menu_name',
        'description',
        'link',
        'icon',
        'main_uuid',
        'is_active',
        'is_eksternal',
        'is_newtab',
    ];

    protected $hidden = [];

    public static function booted()
    {
        // run parent
        parent::boot();

        static::creating(function ($data) {
            $data->created_by = (isset(Auth::user()->uuid)) ? Auth::user()->uuid : null;
        });

        static::updating(function ($data) {
            $data->updated_by = (isset(Auth::user()->uuid)) ? Auth::user()->uuid : null;
        });

        // add in custom deleting
        static::deleting(function ($data) {
            $data->where('uuid', $data->uuid)->update([
                'deleted_by' => (isset(Auth::user()->uuid)) ? Auth::user()->uuid : null,
            ]);
        });
    }


    public function childs()
    {
        return $this->hasMany('App\Models\Menus', 'main_uuid', 'uuid');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Menus', 'main_uuid', 'uuid');
    }
}
