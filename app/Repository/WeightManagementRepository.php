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

    public function edit($id, $weight, $fat_rate, $bmi)
    {
        $model = $this->getItemById($id);
        $model->weight = $weight;
        $model->fat_rate = $fat_rate;
        $model->bmi = $bmi;
        $model->save();
    }

    public function list($user)
    {
        return $user->WeightManagements()->get();
    }

    public function getItemById($id)
    {
        return WeightManagement::where(['id' => $id])->first();
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
