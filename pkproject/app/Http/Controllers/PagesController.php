<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('MainPage');
    }

    public function service(){
        return view('ServiceTemplate');
    }

}
