<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Attendances;
//use App\Http\Controllers\Admin\Route;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Admin\Auth;
use Auth;

class updateAttendanceInfoController extends Controller
{
    public function updateAttendanceInfo(Request $req){
       // if(Auth::check()){
             // $userid = auth()->user()->emp_id;
             // fetching from request
                $emp_id = $req->emp_id;
                $admin_id = $req->id;
                $in_time = $req->in_time;
                $out_time = $req->out_time;
                $status = $req->status;
                $overtime = $req->overtime;
            // calculating date and time
                $date_time = Carbon::now();
                $cur_date = $date_time->toDateString();
                $time = $date_time->toTimeString();
                $decision_time = Carbon::parse($time)->format('H:i:s');
            // fetch data from tables
                $user = Employee::where('emp_id', '=', $emp_id)->first();
                $cur_status_admin =  Admin::where('id', $admin_id)->first();
                $cur_status_attendance =  Attendances::where('emp_id', $emp_id)->where('date',$cur_date)->first();
                
                $in_time_code = '0';
                $out_time_code = '0';
                $status_code = '0';
                $overtime_code = '0';
                if($cur_status_attendance->in_time != $in_time){
                    $in_time_code = '1';
                } 
                if($cur_status_attendance->out_time != $out_time){
                    $out_time_code = '1';
                }
                if($cur_status_attendance->status != $status){
                    $status_code = '1';
                }
                if($cur_status_attendance->overtime != $overtime){
                    $overtime_code = '1';
                }
               
                // sending data to the login api
                $req->request->add(['emp_id' => $emp_id]);
                $req->request->add(['password' => $user->password]);
                $req->request->add(['in_time_code' => $in_time_code]);

                $request = Request::create('/api/login', 'POST');
                $response = json_decode(Route::dispatch($request)->getContent());

                if($cur_status_admin){

                    return response()->json([
                        "admin_name" => $cur_status_admin->name,
                        "intime" => $in_time,
                        "outtime" =>$out_time,
                        "status" =>$status,
                        "overtime" =>$overtime,
                        "status_code_in" => $in_time_code,
                        "status_code_out" => $out_time_code,
                        "status_code" => $status_code,
                        "code" => $response,
                        "emp_id" => $emp_id]);
                }else{
                    return ["res" => "user id => ".$admin_id." don't have access to updated"];
                }

        //  }
    }
}
