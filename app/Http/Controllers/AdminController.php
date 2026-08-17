<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //test
    public function index()
    {
        return view('admin.dashboard');
    }
}
