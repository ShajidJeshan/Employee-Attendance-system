<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Employee;
use App\Models\Attendances;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class automaticUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
                       // $cur_status =  Attendances::select('emp_id','date')->where([['emp_id', '=',$each_emp_id->emp_id],['date' , '=', NULL]])->first();

            // $allInfo_employee_table = Employee::all();
            // //echo $allInfo_employee_table;
            // $date_time = Carbon::now();
            // $cur_date = $date_time->toDateString(); 
           
            // $time = $date_time->toTimeString(); 
            // $decision_time = Carbon::parse($time)->format('H:i:s');
            

            // foreach($allInfo_employee_table as $each_emp_id){
            //     echo  $each_emp_id->emp_id;
            //     echo "->";
            //     echo $cur_date;
            //     echo $decision_time;

            //    $cur_status =  Attendances::select('emp_id','date')->where('emp_id', $each_emp_id->emp_id)->first();
            //     // if($cur_date == $date){

            //     // }
            //       // if( $attendance_tbl_info == NULL && $attendance_tbl_info->date == $todays_date && $present_time > '12:30:00'){

            //     // }
            //     // if( $attendance_tbl_info == NULL && $attendance_tbl_info->date == $todays_date && $present_time > '12:30:00'){

            //     // if( $cur_status == NULL && $decision_time > '01:30:00' && $decision_time < '06:00:00'){

            //     //     /// send mail
            //     //    Mail::raw ("sda",$each_emp_id->emp_id, function($message) {
            //     //        $message ->from('paresh53710@gmail.com');
            //     //        $message->to($each_emp_id->emp_id)->subject('sent a mail');

            //     //    });
            //     //  $this->info('minute updte has been successful');

            //     // }
            //     // else if( $cur_status == NULL && $decision_time > ':40:20'){
            //         if($cur_status->date != NULL){
            //             echo "ager data";

            //         }
            //         if( $cur_status == NULL && $decision_time > '09:07:20'){
            //               // echo  $each_emp_id->emp_id;
            //                 $new_user = new Attendances;
            //                 $new_user->emp_id = $each_emp_id->emp_id;
            //                 $new_user->out_time = 'NULL';
            //                 $new_user->overtime = '0';
            //                 $date_time = Carbon::now();
            //                 $new_user->date =  $date_time->toDateString(); 
            //                 $new_user->in_time = $date_time->toTimeString(); 
    
            //                 $new_user->status = '3'; /// for absent status will be 3 
            //                 $res = $new_user->save();  // to save the data in attendance table
            //                 if($res){
            //                     echo "saved ";
            //                 }
            //                 else{
            //                     echo "not saved";
            //                 }
    
            //     }
             
            // } 
        return 0;
    }
}
