<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Models\Admin;
use App\Models\Employee;
use App\Models\EmployeeCreation;
use App\Http\Requests\FormValidation;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function __construct()
    {
        // config(['app.timezone' => 'Asia/Dhaka']);

    }

    public function adminLogin()
    {
        return view('admin-panel.dashboard');
    }

    public function EmployeeCreate(FormValidation $req)
    {
        $search = EmployeeCreation::AdminEmployeeSearch($req->all());
        $data = EmployeeCreation::AdminEmployeeCreation($req->all());

        //dd($data);

        if($data != NULL){
            return response()->json([
                'code' => 0,
                'message' => 'Employee Created Successfully',
                'data' => [
                    'Data Inserted Successfully',
                    Mail::to($data['email'])->send(new WelcomeMail($data))
                ]
            ]);
        }
        else{
            return response()->json([
                 'code' => 2,
                 'message' => 'Employee Can not be created',
            ]);
         }
    }

    //Admin Employee Update
    public function EmployeeUpdate(Request $req)
    {
        //dd($req->name);
        // if(!$req->name){
        //     return response()->json([
        //         'code' => '2',
        //         'message' => 'No info About the Employee'
        //     ]);
        // }else{
            // $req->validate([
            //     'name' => 'required'
            // ]);

            $data = Employee::getAdminEmployeeInfo($req->all());

            if(sizeof($data) <= 0){

                return response()->json([
                    'code' => 1,
                    'message'=>'Data not found',
                ]);

            }else{

                //dd($data);

                 //$value = Employee::AdminEmployeeUpdate($req, $data);

                return response()->json([
                    'code'=>0,
                    'message'=>'OK',
                    'data'=> $data,
                ]);
            }
        // }
    }

    //Admin Panel Employee Delete
    public function EmployeeDelete(Request $req)
    {

        if(!$req->name){
            return response()->json([
                'code' => '2',
                'message' => 'No Employee Found',
            ]);
        }else{
            $req->validate([
                'name' => 'required'
            ]);
            //dd($req->name);

             $data = Employee::AdminEmployeeDelete($req->all());
             //dd($data);
             if($data == NULL)
             {
                 return response()->json([
                    'code' => 0,
                    'message' => 'Data Deleted Successfully' 
                 ]);
             }
             else{
                 return response()->json([
                     'code' => '1',
                     'message' => 'Problem in Deleting Data'
                 ]);
             }
        
        }
    }
}
