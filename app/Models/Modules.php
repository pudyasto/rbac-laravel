<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Modules extends Model
{
    use HasFactory;
    use Uuid;
    // use Notifiable, SoftDeletes;
    //
    protected $table = 'modules';

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'link',
        'description',
        'is_active',
    ];

    protected $hidden = [];

    public static function booted()
    {
        // run parent
        parent::boot();

        static::creating(function ($data) {
            $data->created_by = (isset(Auth::user()->id)) ? Auth::user()->id : null;
        });

        static::updating(function ($data) {
            $data->updated_by = (isset(Auth::user()->id)) ? Auth::user()->id : null;
        });
    }

    public function permission()
    {
        return $this->hasMany('Spatie\Permission\Models\Permission', 'modules_uuid', 'uuid');
    }
}
