<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EatingTarget extends Model
{
    protected $table = 'eating_targets';
    
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
