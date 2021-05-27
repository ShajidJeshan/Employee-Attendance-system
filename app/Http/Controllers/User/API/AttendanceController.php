<?php

namespace App\Http\Controllers\User\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendances;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Auth;

class AttendanceController extends Controller
{
    //A Employee's Full Details
    public function HistoryLogAPI(Request $req)
    {

        if(!$req->id){
            return response()->json([
                'code' => '2',
                'message' => 'No Employee Found',
            ]);
        }else{
            $req->validate([
                'id' => 'required'
            ]);

            $data = Attendances::SearchById($req->all());
            $monthly_working_days = Attendances::TotalYearlyWorkingDays($req->all());

            if(sizeof($data)<=0){
                return response()->json([
                    'code' => 1,
                    'message' => 'Invalid Id or Month'
                ]);
            }else{
                return response()->json([
                    'code' => 0,
                    'message' => 'Ok',
                    'data' => [
                        $monthly_working_days,
                    ]
                ]);
            }
        }

    }

    //Each day of the Month Information API
    public function MonthEachDayAPI(Request $request)
    {
        if(!$request->id){
            return response()->json([
                'code' => 2,
                'message' => 'No Data about the Employee'
            ]);
        }else{
            $request->validate([
                'id' => 'required',
                'month' => 'required',
                'year' => 'required'
            ]);

            $data = Attendances::MonthlyEachDay($request->all());

            if(sizeof($data)<=0){
                return response()->json([
                    'code' => 1,
                     'message' => 'Invalid Id or Month'
                ]);
            }
            else{
                return response()->json([
                    'code' => 0,
                    'message' => 'Ok',
                    'data' => $data
                ]);
            }
        }
    }


    //Each Month Information API
    public function GetMonthLogAPI(Request $request)
    {
      //  dd($data);
       // dd($request->header('Authorization'));
        // $header = $request->header('Authorization');
        
        // return ["res" => $request->all(), "token" => $header ];
        if(!$request->id){
            return response()->json([
                'code' => 2,
                'message' => 'No data about employee'
            ]);
        }else{
            $request->validate([
                'id' => 'required',
                'month' => 'required',
                'year' => 'required'
            ]);

            $data = Attendances::SearchByMonth($request->all());
            $sum = Attendances::monthlyOvertime($request);
            $late = Attendances::monthlyLate($request);
            $present = Attendances::monthlyPresent($request);
            $absent = Attendances::monthlyAbsent($request);
            $monthly_working_days = Attendances::totalmonthlyWorkingDays($request);

            if(sizeof($data)<=0){
                 return response()->json([
                     'code' => 1,
                     'message' => 'Data Not Found About the Specific Details'
                 ]);
             }

            else{
                return response()->json([
                    'code' => 0,
                    'message' => 'Ok',
                    'data' => [
                        'total_working_days' => $monthly_working_days,
                        'monthly_working_days' => $present,
                        'total_late' => $late,
                        'total_leave' => $absent,
                        'overtime'=> $sum,
                    ]
                ]);
            }
        }
    }
}
