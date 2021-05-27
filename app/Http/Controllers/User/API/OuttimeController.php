<?php

namespace App\Http\Controllers\User\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Models\Employee;
use App\Models\Attendances;

class OuttimeController extends Controller
{
    public function outTime(Request $req)
    {
        if(Auth::check()){
            $emp_id = auth()->user()->emp_id;
        }
        //$emp_id = $req->emp_id;
        $date_time = Carbon::now();
        $cur_date = $date_time->toDateString();
        $time = $date_time->toTimeString();
        $decision_time = Carbon::parse($time)->format('H:i:s');


        $to = \Carbon\Carbon::createFromFormat('H:s:i', $decision_time);
        $from = \Carbon\Carbon::createFromFormat('H:s:i', '18:00:00');
        $overtime = $to->diffInHours($from);

        if($overtime > 0){
            $cur_status =  Attendances::select('emp_id')->where('emp_id', $emp_id)->where('date',$cur_date)->update(["overtime"=>$overtime]);
        }
        else{
            $overtime = '0';
        }
        if($cur_status){
            echo "Data successfully updated and overtime updated for ".$emp_id;
        }
        else{
            echo "Data not successfully updated";
        }

        return response()->json([
            'code'=>'0',
            'message'=>'successfully updated outtime information',
            'data' => [
                'emp_id' => $emp_id,
                'overtime'=>$overtime,
                'out_time'=>$time]
            ]);
    }
}
