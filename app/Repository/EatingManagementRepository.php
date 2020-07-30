<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Model\EatingManagement;
use App\Model\Timezone;
use App\User;

class EatingManagementRepository
{
    private $paramNames = ['date', 'item', 'protein', 'liqid', 'carbo', 'calorie'];

    public function __construct()
    {

    }

    /**
     * データを１件追加する
     */
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

    /**
     * データを取得して日毎にまとめる
     */
    public function getDailyList($user, $page = 1, $days = 10)
    {
        $dates = [];
        for($i = ($page - 1); $i < ($days * $page) ; $i++) {
            $dates[] = date('Y-m-d', strtotime('today - '.$i.' day'));
        }

        $eatings = $user->EatingManagements()
             ->whereIn(DB::raw('date_format(date, "%Y-%m-%d")'), $dates)
             ->get();

        // 日毎に集計
        $dailyDatas = [];
        foreach($eatings as $eating) {
            for($j = 2; $j < count($this->paramNames); $j++) {
                if(!array_key_exists($eating->date, $dailyDatas)) {
                    $dailyDatas[$eating->date] = [];
                }
                if(!array_key_exists($this->paramNames[$j], $dailyDatas[$eating->date])) {
                    $dailyDatas[$eating->date][$this->paramNames[$j]] = 0;
                }
                $dailyDatas[$eating->date][$this->paramNames[$j]] += $eating->{$this->paramNames[$j]};
            }
        }

        // 戻り値に変換
        $retDatas = [];
        $index = 0;
        foreach($dailyDatas as $dailykey => $dailyData) {
            $retDatas[$index][$this->paramNames[0]] = $dailykey;
            for($k = 2; $k < count($this->paramNames); $k++) {
                $retDatas[$index][$this->paramNames[$k]] = $dailyDatas[$dailykey][$this->paramNames[$k]];
            }
        }

        return $retDatas;
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
