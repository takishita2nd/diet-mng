<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WeightManagement extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
