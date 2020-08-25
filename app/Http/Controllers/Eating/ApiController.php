<?php

namespace App\Http\Controllers\Eating;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repository\EatingManagementRepository;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->eatingManagement = new EatingManagementRepository();
    }

    /**
     * データを１件登録する
     */
    public function add(Request $request)
    {
        $paramNames = $this->eatingManagement->getParam();

        $param = [];
        foreach($paramNames as $name) {
            $param[$name] = $request->contents[$name];
        }

        $this->eatingManagement->add($param, Auth::user(), $request->contents['timezone']);
        
        return response()->json();
    }

    /**
     * データ一覧を取得する
     */
    public function list(Request $request)
    {
        return response()->json(['dataLists' => $this->eatingManagement->getDailyList(Auth::user())]);
    }

    /**
     * 一日分のデータを取得する
     */
    public function detail(Request $request)
    {
        return response()->json(['dataLists' => $this->eatingManagement->getDetails(Auth::user(), $request->contents['date'])]);
    }

    /**
     * データを一件取得する
     */
    public function update(Request $request)
    {
        $paramNames = $this->eatingManagement->getParam();

        $param = [];
        foreach($paramNames as $name) {
            $param[$name] = $request->contents[$name];
        }

        $this->eatingManagement->update($param, Auth::user(),  $request->contents['id'], $request->contents['timezone']);
        
        return response()->json();
    }

    /**
     * データを一件削除する
     */
    public function delete(Request $request)
    {
        $this->eatingManagement->delete(Auth::user(),  $request->contents['id']);

        return response()->json();
    }

    /**
     * グラフ用データを取得する
     */
    public function graph(Request $request)
    {
        return response()->json(['data' => $this->eatingManagement->getDaily(Auth::user(), $request->contents['date'])]);
    }
}
