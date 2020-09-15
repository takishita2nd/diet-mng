<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{
    protected $table = 'timezones';
    
    public function Eating()
    {
        return $this->belongsToMany('App\Model\EatingManagement');
    }
}
