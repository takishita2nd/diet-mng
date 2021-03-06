<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EatingHistoryItem extends Model
{
    protected $table = 'eating_history_items';

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
