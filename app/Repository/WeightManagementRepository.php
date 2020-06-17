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

    public function delete($id, $user)
    {
        $model = $this->getItemById($id);
        $this->detachToUser($model, $user);
        $model->delete();
    }

    public function list($user, $page = 1)
    {
        return $user->WeightManagements()
                    ->orderBy('datetime', 'desc')
                    ->skip(10 * ($page - 1))
                    ->limit(10)
                    ->get();
    }

    public function getTotalRecord($user)
    {
        return $user->WeightManagements()->count();
    }

    public function getGraphData($user)
    {
        $datetimes = [];
        for($i = 0; $i < 10 ; $i++) {
            $datetimes[] = date('Y-m-d', strtotime('today - '.$i.' day'));
        }

        return $user->WeightManagements()
                    ->whereIn(DB::raw('date_format(datetime, "%Y-%m-%d")'), $datetimes)
                    ->get();
    }

    public function getItemById($id)
    {
        return WeightManagement::where(['id' => $id])->first();
    }

    public function attachToUser($model, $user)
    {
        $model->users()->attach($user);
    }

    public function detachToUser($model, $user)
    {
        $model->users()->detach($user);
    }

    public function getParam()
    {
        return $this->paramNames;
    }
}
