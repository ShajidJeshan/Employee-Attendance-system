<?php

namespace App\Models;

use App\Http\Controllers\LogInController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Attendances extends Model
{
    use HasFactory;


    public static function SearchById($data)
    {
        $value = Attendances::select('created_at')->where('emp_id', '=', $data['id'])->get();

        return $value;

    }

    //History Log API Start
    public static function AllYears($data)
    {
        $firstDate = Attendances::where('emp_id', '=', $data['id'])->orderBy('created_at', 'asc')->first()->created_at;

        $lastDate = Attendances::where('emp_id', '=', $data['id'])->orderBy('created_at', 'desc')->first()->created_at;

        $values = Attendances::where('emp_id', '=', $data['id'])
            ->whereBetween('created_at', [$firstDate, $lastDate])
            ->get();

        //Year
        $years = $values->unique(function($item){
            return $item['created_at']->year;
        })->map(function($item){
            return $item['created_at']->year;
        })->sortDesc()->toArray();


        $groupByYear = array();
        foreach ($years as $year){
            $values = Attendances::where('emp_id', '=', $data['id'])
                ->whereYear('created_at', '=', $year)
                ->get();

            //Month
            
            $months = $values->unique(function($item){
                return $item['created_at']->month;
            })->map(function($item){
                return $item['created_at']->month;
            })->sortDesc()->toArray();

            $groupByMonth = array();

            foreach ($months as $month){
                $val = Attendances::select('overtime')
                    ->where('emp_id', '=', $data['id'])
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)
                    ->sum('overtime');
                    //->get();
                $month   = Carbon::createFromFormat('!m', $month)->format('F');
                $groupByMonth[$month] = $val;
            }
            $groupByYear[$year] = $groupByMonth;
            
        }

        return $groupByYear;

    }

    
    public static function TotalYearlyWorkingDays($data)
    {

        $firstDate = Attendances::where('emp_id', '=', $data['id'])->orderBy('created_at', 'asc')->first()->created_at;

        $lastDate = Attendances::where('emp_id', '=', $data['id'])->orderBy('created_at', 'desc')->first()->created_at;

        $values = Attendances::where('emp_id', '=', $data['id'])
            ->whereBetween('created_at', [$firstDate, $lastDate])
            ->get();
        
        $years = $values->unique(function($item){
            return $item['created_at']->year;
        })->map(function($item){
            return $item['created_at']->year;
        })->sortDesc()->toArray();

        $groupByYear = array();
        foreach ($years as $year){
            $values = Attendances::where('emp_id', '=', $data['id'])
                ->whereYear('created_at', '=', $year)
                ->get();

            //Month
            $months = $values->unique(function($item){
                return $item['created_at']->month;
            })->map(function($item){
                return $item['created_at']->month;
            })->sortDesc()->toArray();

            $groupByMonth = array();

            foreach ($months as $month){
                //Total Working Days in a Month Start
                $val = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                //Total Working Days in a Month Finish

                //Total Present Start
                $present = Attendances::select('status')
                        ->whereYear('created_at', '=', $year)
                        ->whereMonth('created_at', '=', $month)
                        ->where("emp_id", '=', $data['id'])
                        ->where('status', '=', '1')
                        ->count();

                $late = Attendances::select('status')
                        ->whereYear('created_at', '=', $year)
                        ->whereMonth('created_at', '=', $month)
                        ->where("emp_id", '=', $data['id'])
                        ->where('status', '=', '2')
                        ->count();

                $total_present_sum = $present + $late;
                //Total Present Finish

                //Total overtime in a month start
                $ovr = Attendances::select('overtime')
                        ->whereYear('created_at', '=', $year)
                        ->whereMonth('created_at', '=', $month)
                        ->where("emp_id", '=', $data['id'])
                        ->sum('overtime');
                //Total overtime in a month finish

                //Monthly Late Start
                $late = Attendances::select('status')
                        ->whereYear('created_at', '=', $year)
                        ->whereMonth('created_at', '=', $month)
                        ->where("emp_id", '=', $data['id'])
                        ->where('status', '=', '2')
                        ->count();
                //Monthly Late Finish

                //Montly Leave Start
                $absent = Attendances::select('status')
                        ->whereYear('created_at', '=', $year)
                        ->whereMonth('created_at', '=', $month)
                        ->where("emp_id", '=', $data['id'])
                        ->where('status', '=', '0')
                        ->count();
                //Monthly Leave Finish

                //Date Start
                $date = Attendances::select('date','in_time','out_time','status')
                        ->whereYear('created_at', '=', $year)
                        ->whereMonth('created_at', '=', $month)
                        ->where("emp_id", '=', $data['id'])->get();
                //Date Finish

                $groupByMonth[$month] = array(
                    'total_working_days' => $val,
                    'monthly_working_days' => $total_present_sum,
                    'total_late' => $late,
                    'total_leave' => $absent,
                    'overtime' => $ovr,
                    'daily_details' =>$date
                    
                );
            }
            $groupByYear[$year] = array(
                $groupByMonth
            );
        }

        //$month_working_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        return $groupByYear;
    }

    public static function MonthlyEachDay($data)
    {
        $information = Attendances::select('date','in_time','out_time','status')
            ->whereYear('created_at', '=', $data['year'])
            ->whereMonth('created_at', '=', $data['month'])
            ->where("emp_id", '=', $data['id'])
            ->get();
        return $information;

    }
    
    //History Log API Finish

    public static function SearchByMonth($data)
    {

        $start = Carbon::createFromFormat('m/Y', $data['month'] . '/' . $data['year'])
            ->firstOfMonth()
            ->format('Y-m-d');
        $end = Carbon::createFromFormat('m/Y', $data['month'] . '/' . $data['year'])
            ->lastOfMonth()
            ->format('Y-m-d');

        $value = Attendances::where('emp_id', '=', $data['id'])
            ->whereBetween('date', [$start, $end])
            ->get();
        return $value;

    }


    //Current Month Log APIs Start

    //Total Days in a month count
    public static function totalmonthlyWorkingDays($data)
    {
        $month_working_days = cal_days_in_month(CAL_GREGORIAN, $data->month, $data->year);
        return $month_working_days;
    }

    //Monthly Overtime calculation in a month
    public static function monthlyOvertime($data)
    {
        $sum = Attendances::select('overtime')
            ->whereYear('created_at', '=', $data->year)
            ->whereMonth('created_at', '=', $data->month)
            ->where("emp_id", '=', $data->id)
            ->sum('overtime');
        return $sum;
    }

    //Monthly Late Calculation
    public static function monthlyLate($data)
    {
        $late = Attendances::select('status')
            ->whereYear('created_at', '=', $data->year)
            ->whereMonth('created_at', '=', $data->month)
            ->where("emp_id", '=', $data->id)
            ->where('status', '=', '2')
            ->count();
        return $late;
    }

    //Total Present in a month
    public static function monthlyPresent($data)
    {
        $present = Attendances::select('status')
            ->whereYear('created_at', '=', $data->year)
            ->whereMonth('created_at', '=', $data->month)
            ->where("emp_id", '=', $data->id)
            ->where('status', '=', '1')
            ->count();

        $late = Attendances::select('status')
            ->whereYear('created_at', '=', $data->year)
            ->whereMonth('created_at', '=', $data->month)
            ->where("emp_id", '=', $data->id)
            ->where('status', '=', '2')
            ->count();
        $total_present_sum = $present + $late;
        return $total_present_sum;
    }

    //Total Absent in a month
    public static function monthlyAbsent($data)
    {
        $absent = Attendances::select('status')
            ->whereYear('created_at', '=', $data->year)
            ->whereMonth('created_at', '=', $data->month)
            ->where("emp_id", '=', $data->id)
            ->where('status', '=', '0')
            ->count();
        return $absent;
    }
    //Current Month Log APIs Finish
}
