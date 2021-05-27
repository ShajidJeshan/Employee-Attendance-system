<?php

namespace App\Http\Controllers\User\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Attendances;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class IntimeController extends Controller
{
    public function inTime(Request $req){

        return ["result"=>"return from intime api"];

    }
}
