<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function WeightManagements()
    {
        return $this->belongsToMany('App\Model\WeightManagement');
    }

    public function EatingManagements()
    {
        return $this->belongsToMany('App\Model\EatingManagement');
    }

    public function EatingTargets()
    {
        return $this->belongsToMany('App\Model\EatingTarget');
    }

    public function EatingHistoryItems()
    {
        return $this->belongsToMany('App\Model\EatingHistoryItem');
    }
}
