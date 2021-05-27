<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        // config(['app.timezone' => 'Asia/Dhaka']);

    }

    public function userDashboard(){
        return view('user-panel.dashboard.dashboard');
    }
}
