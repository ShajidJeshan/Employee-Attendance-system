<?php

namespace App\Http\Controllers\User\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\Employee;
use App\Models\Attendances;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Auth;

class logoutController extends Controller
{
   public function logOut(Request $req){
      // Auth::Employee()->token()->delete();
      if(Auth::check()){
         $userid = auth()->user()->emp_id;

      Auth::user()->tokens()->delete();
      return ['res' => 'Successfully Logged Out','userId' => $userid ];
      }

   }
 }

