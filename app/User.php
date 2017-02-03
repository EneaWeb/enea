<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    protected $role;

	public function __construct()
	{
		$this->connection = 'mysql';
	}

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 
        'email', 
        'password', 
        'active'
    ];

    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
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
        return \App\Role::find(\App\RoleUser::where('user_id', $this->id)->first()['role_id'])->name;
    }
    
    public function options()
    {
        return $this->hasOne('\App\UserOption');
    }
    
    public function orders()
    {
        return $this->hasMany('\App\Order');
    }
    
    public function priceLists()
    {
        return $this->belongsToMany('\App\PriceList', 'user_price_list');
    }
}
