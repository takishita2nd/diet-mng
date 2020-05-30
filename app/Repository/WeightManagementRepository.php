<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Model\WeightManagement;
use App\User;

class WeightManagementRepository
{
    private $paramNames = ['datetime', 'weight', 'fat_rate', 'bmi'];

    public function __construct()
    {

    }

    public function add($param, $user)
    {
        $model = new WeightManagement();
        foreach($this->paramNames as $name)
        {
            $model->$name = $param[$name];
        }
        $model->save();
        $this->attachToUser($model, $user);
    }

    public function attachToUser($model, $user)
    {
        $model->users()->attach($user);
    }

    public function getParam()
    {
        return $this->paramNames;
    }
}
