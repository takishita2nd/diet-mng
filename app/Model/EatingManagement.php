<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EatingManagement extends Model
{
    protected $table = 'eating_managements';
    
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function timezones()
    {
        return $this->belongsToMany('App\Model\Timezone');
    }
}
