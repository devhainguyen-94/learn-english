<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin');
    }
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * @return int
     */
    public function home1(){
        return 1;
    }

    /**
     * @return int
     */
    public function home2(){
        return 1;
    }
    public function test3(){
        return 'test3';
    }
}
