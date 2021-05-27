<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;

class UserLogoutController extends Controller
{

    public function userLogout(Request $request){
        
        $request = Request::create('/api/logout', 'POST');
        $response = json_decode(Route::dispatch($request)->getContent());
        dd($response);
        // if($response->code == '4' || $response->code == '6'){
        //     return redirect()->route('userLogin');
        // } else {
        //     return redirect()->route('userLogin');
        // }
    }
}
