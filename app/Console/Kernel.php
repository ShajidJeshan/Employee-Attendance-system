<?php

namespace App\Console;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\Employee;
use App\Models\Attendances;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
            $schedule->call(function () {

            $allInfo_employee_table = Employee::all();
            $date_time = Carbon::now();
            $cur_date = $date_time->toDateString(); 
           
            $time = $date_time->toTimeString(); 
            $decision_time = Carbon::parse($time)->format('H:i:s');

            $yesterday = Carbon::yesterday();

            foreach($allInfo_employee_table as $each_emp_id){
       
               $cur_status =  Attendances::select('emp_id','out_time')->where('emp_id', $each_emp_id->emp_id)->where('date',$cur_date)->first();
               $cur_status_temp = (array) $cur_status ;
           
               $automatic_out_time = '18:00:00';
               if(sizeof($cur_status_temp)>0 && $decision_time > '19:00:00' && $cur_status->out_time == NULL){
                $cur_status =  Attendances::select('emp_id')->where('emp_id', $each_emp_id->emp_id)->where('date',$cur_date)->update(["out_time"=>$automatic_out_time]);

                    echo "outtime updated";
               }
               else if(sizeof($cur_status_temp) <=0 && $decision_time > '02:00:00' && $decision_time <= '18:00:00'){
                    
                    /// send a mail 
                    echo "sending mail";           
               
                }
                else if(sizeof($cur_status_temp) <=0 && $decision_time > '19:00:00'){
        
                        echo  "data store 2nd";
                        $new_user = new Attendances;
                        $new_user->emp_id = $each_emp_id->emp_id;
                        $new_user->out_time = 'NULL';
                        $new_user->overtime = '0';
                        $date_time = Carbon::now();
                        $new_user->date =  $date_time->toDateString(); 
                        $new_user->in_time = $date_time->toTimeString(); 

                        $new_user->status = '2'; /// for absent status will be 2 
                        $res = $new_user->save();  // to save the data in attendance table
                        if($res){
                            echo "saved ";
                        }
                        else{
                            echo "not saved";
                        }
    
                }
            }

       })->everyMinute();
   
    }
    

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}