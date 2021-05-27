<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserHistoryController extends Controller
{
    public function __construct()
    {
        // config(['app.timezone' => 'Asia/Dhaka']);

    }

    public function userHistory(){
        return view('user-panel.history.history');
    }
}

?>