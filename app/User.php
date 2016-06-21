<?php

/*
==================
    GENERAL DB
==================
*/

namespace App;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // spatie
    use HasRoles;
    protected $role;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'name', 'email', 'password', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * Relations
     */
    
    public function brands()
    {
        return $this->belongsToMany('\App\Brand');
    }
    
    public function profile()
    {
        return $this->hasOne('\App\Profile');
    }
    
    public function roles()
    {
        return $this->belongsToMany('\App\Role');
    }
    
    public function role()
    {
        $role = $this->roles->first()->name;
        return $role;
    }
    
    public function options()
    {
        return $this->hasOne('\App\UserOption');
    }
    
    public function orders()
    {
        return $this->hasMany('\App\Order');
    }
}
