<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    //index
    public function index(){
        return view('jobs.index');
    }
    //create
    public function create(){
        $authUser = Auth::user();

        return view('jobs.add');
    }
}
