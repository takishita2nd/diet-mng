<?php

namespace App\Http\Controllers\Weight;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repository\WeightManagementRepository;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->weightManagement = new WeightManagementRepository();
    }

    /**
     * データを１件登録する
     */
    public function add(Request $request)
    {
        $param = $this->weightManagement->getParam();
        $this->weightManagement->add([
            $param[0] => date('Y-m-d H:i'),
            $param[1] => $request->contents["weight"],
            $param[2] => $request->contents["fat_rate"],
            $param[3] => $request->contents["bmi"],
        ], Auth::user());
        
        return response()->json();
    }

    /**
     * データを１件更新する
     */
    public function edit(Request $request)
    {
        $param = $this->weightManagement->getParam();
        $this->weightManagement->edit( $request->contents["id"], 
            $request->contents["weight"],
            $request->contents["fat_rate"],
            $request->contents["bmi"]
        );
        
        return response()->json();
    }

    /**
     * データを１件削除する
     */
    public function delete(Request $request)
    {
        $this->weightManagement->delete($request->contents["id"], Auth::user());
        
        return response()->json();
    }

    /**
     * データを取得する
     */
    public function list(Request $request)
    {
        return response()->json(['dataLists' => $this->weightManagement->list(Auth::user(), $request->contents["page"])]);
    }

    /**
     * データのレコード数を取得する
     */
    public function total(Request $request)
    {
        return response()->json(['total' => $this->weightManagement->getTotalRecord(Auth::user())]);
    }

    /**
     * グラフ用データを取得する
     */
    public function graph(Request $request)
    {
        return response()->json(['datas' => $this->weightManagement->getGraphData(Auth::user(), $request->contents["interval"])]);
    }
}
