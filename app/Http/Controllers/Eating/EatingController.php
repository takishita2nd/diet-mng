<?php

namespace App\Http\Controllers\Eating;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EatingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('eating');
    }

    public function detail($date)
    {
        return view('eatingdetail', ['date' => $date]);
    }
}
