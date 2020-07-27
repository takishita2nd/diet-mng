<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Model\EatingManagement;
use App\Model\Timezone;
use App\User;

class EatingManagementRepository
{
    private $paramNames = ['date', 'item', 'protein', 'riqid', 'carbo', 'calorie'];

    public function __construct()
    {

    }

    public function add($param, $user, $timezone)
    {
        $model = new EatingManagement();
        foreach($this->paramNames as $name)
        {
            $model->$name = $param[$name];
        }
        $model->save();
        $time = Timezone::where('id', $timezone)->first();

        $this->attachToUser($model, $user);
        $this->attachToTimezone($model, $time);
    }

    public function attachToUser($model, $user)
    {
        $model->users()->attach($user);
    }

    public function detachToUser($model, $user)
    {
        $model->users()->detach($user);
    }

    public function attachToTimezone($model, $timezone)
    {
        $model->timezones()->attach($timezone);
    }

    public function detachToTimezone($model, $timezone)
    {
        $model->timezones()->detach($timezone);
    }

    public function getParam()
    {
        return $this->paramNames;
    }

}
