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

}