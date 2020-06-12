<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WeightManagement extends Model
{
    protected $table = 'weight_managements';
    
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
