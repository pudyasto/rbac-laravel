<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use Uuid;
    
    protected $table = 'users';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'nik',
        'name',
        'username',

        'gender',
        'department',
        'status',

        'email',
        'password',

        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];


    protected function defaultProfilePhotoUrl()
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=0c488c&background=EBF4FF';
    }

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
}
