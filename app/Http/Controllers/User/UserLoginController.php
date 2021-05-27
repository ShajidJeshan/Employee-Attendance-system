<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;

class UserLoginController extends Controller
{

    public function loginUser(Request $request){
        $request = Request::create('/api/login', 'POST');
        $response = json_decode(Route::dispatch($request)->getContent());
        // dd($response);
        if($response->code == '4' || $response->code == '6'){
            return redirect()->route('userDashboard');
        } else {
            return redirect()->route('userLogin');
        }
    }
}
