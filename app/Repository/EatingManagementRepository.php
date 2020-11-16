<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Model\EatingHistoryItem;
use App\Model\EatingManagement;
use App\Model\EatingTarget;
use App\Model\EatingTemplateItem;
use App\Model\Timezone;
use App\User;

class EatingManagementRepository
{
    private $paramNames = ['date', 'item', 'protein', 'liqid', 'carbo', 'calorie'];
    private $targetParamNames = ['protein', 'liqid', 'carbo', 'calorie'];
    private $templateParamNames = ['item', 'protein', 'liqid', 'carbo', 'calorie'];

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
     * ヒストリにデータを１件追加する
     */
    public function addHistory($param, $user)
    {
        $model = new EatingHistoryItem();
        foreach($this->templateParamNames as $name)
        {
            $model->$name = $param[$name];
        }
        $model->save();

        $this->attachToUser($model, $user);
    }

    public function getHistory()
    {
        return EatingHistoryItem::all();
    }

    public function registTemplate($ids)
    {
        $records = EatingHistoryItem::whereIn('id', $ids )->get();
        foreach($records as $record)
        {
            $model = new EatingTemplateItem();
            foreach($this->templateParamNames as $name)
            {
                $model->$name = $record[$name];
            }
            $model->save();
            $record->delete();
        }
    }

    public function searchKeyword($keyword, $user)
    {
        $result = [];
        $records1 = EatingTemplateItem::where('item', 'like', "%$keyword%")->get();
        $records2 = $user->EatingHistoryItems()->where('item', 'like', "%$keyword%")->get();
        if(count($records1) + count($records2) >= 10 )
        {
            return [];
        }
        foreach($records1 as $record)
        {
            $result[] = $record->item;
        }
        foreach($records2 as $record)
        {
            $result[] = $record->item;
        }
        return $result;
    }

    /**
     * データを一件取得する
     */
    public function update($param, $user, $id, $timezone)
    {
        $model = $user->EatingManagements()->where('id', $id)->first();
        foreach($this->paramNames as $name)
        {
            $model->$name = $param[$name];
        }
        $model->save();
        $oldtime = $model->timezones()->first();
        $newtime = Timezone::where('id', $timezone)->first();

        $this->detachToTimezone($model, $oldtime);
        $this->attachToTimezone($model, $newtime);
    }

    /**
     * データを一件削除する
     */
    public function delete($user, $id)
    {
        $model = $user->EatingManagements()->where('id', $id)->first();
        $timezone = $model->timezones()->first();

        $this->detachToUser($model, $user);
        $this->detachToTimezone($model, $timezone);
        $model->delete();
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
            $index++;
        }

        return $retDatas;
    }

    /**
     * 一日あたりのデータを取得する
     */
    public function getDaily($user, $date)
    {
        $eatings = $user->EatingManagements()
            ->where(DB::raw('date_format(date, "%Y-%m-%d")'), $date)
            ->get();

        $retDatas = [];
        for($j = 2; $j < count($this->paramNames); $j++) {
            $retDatas[$this->paramNames[$j]] = 0;
        }
        foreach($eatings as $eating) {
            for($j = 2; $j < count($this->paramNames); $j++) {
                $retDatas[$this->paramNames[$j]] += $eating->{$this->paramNames[$j]};
            }
        }
        return $retDatas;
    }

    public function getDetails($user, $date)
    {
        $eatings = $user->EatingManagements()
            ->where(DB::raw('date_format(date, "%Y-%m-%d")'), $date)
            ->get();
        
        $retDatas = [];
        $index = [0, 0, 0, 0];
        foreach($eatings as $eating) {
            $timezone = $eating->timezones()->first();
            $retDatas[$timezone->id - 1][$index[$timezone->id - 1]]['id'] = $eating->id;
            for($j = 1; $j < count($this->paramNames); $j++) {
                $retDatas[$timezone->id - 1][$index[$timezone->id - 1]][$this->paramNames[$j]] = $eating->{$this->paramNames[$j]};
            }
            $index[$timezone->id - 1]++;
        }
        return $retDatas;
    }

    public function setTarget($param, $user)
    {
        $model = $user->EatingTargets()->first();
        if(is_null($model)) {
            $model = new EatingTarget();
        }

        foreach($this->targetParamNames as $name)
        {
            $model->$name = $param[$name];
        }
        $model->save();

        $this->attachToUser($model, $user);
    }

    public function getTarget($user)
    {
        return $user->EatingTargets()->first();
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

    public function getTargetParam()
    {
        return $this->targetParamNames;
    }

}
