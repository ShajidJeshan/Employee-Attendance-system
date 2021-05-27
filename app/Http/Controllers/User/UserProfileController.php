<?php

namespace App\Http\Controllers\User;

// use App\Models\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class UserProfileController extends Controller
{
    public function __construct()
    {
        // config(['app.timezone' => 'Asia/Dhaka']);

    }

    public function userProfile(){
        return view('user-panel.profile.profile');
    }

    public function userProfileEdit(){
        return view('user-panel.profile.profile');
    }

    public function userProfileUpdate(){
        return redirect("/profile");
    }

}

?>