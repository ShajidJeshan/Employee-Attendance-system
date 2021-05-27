<?php

namespace App\Http\Controllers\User\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendances;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AttendanceController;

use Illuminate\Support\Facades\Route;


class LogInController extends Controller
{
    public function __construct()
    {
        // config(['app.timezone' => 'Asia/Dhaka']);

    }

    public function logIn(Request $req)
    {

        if (!preg_match('/^[\w.-]*$/', $req->emp_id) || $req->emp_id==NULL){
            return response()->json([
                'code'=> 1,
                'message'=> 'Invalid Input',
            ]);
        }
        // use carbon to work with date and time
        $date_time = Carbon::now();
        $cur_date = $date_time->toDateString();
        $time = $date_time->toTimeString();
        $decision_time = Carbon::parse($time)->format('H:i:s');
        /// store requested emp_id and password in two separate variable
        $emp_id = $req->emp_id;
        $password = $req->password;

        $cur_status =  Attendances::where('emp_id', $emp_id)->where('date',$cur_date)->first();
        $user = Employee::where('emp_id', '=', $emp_id)->first();

        if (!$user || (!Hash::check($password,$user->password))) {
            return response()->json([
                'code'=>'5',
                'message' => 'Undefined employee id or password']);
        }
        else{
            // remove previous emp_id and password
            $req->request->remove('emp_id');
            $req->request->remove('password');


            $cur_month = $date_time->month;
            $cur_year = $date_time->year;
            // creating API token using sanctum auth
            $token = $user->createToken('web-app')->plainTextToken;
            /// passing dynamic month and year 
            $req->request->add(['id' => $emp_id]);
            $req->request->add(['month' => $cur_month]);
            $req->request->add(['year' => $cur_year]);
            //passing auth-token as header
            $req->headers->set('Authorization', 'Bearer '.$token);

            $request = Request::create('/api/current_attendance', 'POST');

            $response = json_decode(Route::dispatch($request)->getContent());
           // $response->headers->set('Authorization', 'Bearer '.$request->bearerToken());

            if($cur_status && Hash::check($password,$user->password)){

                return response()->json([

                    'code'=>'6',
                    'message'=>'you are successfully logged in',
                    'data' => [
                    'emp_id' => $user->emp_id,
                    'emp_name'=>$user->name,
                    'email' => $user->email,
                    'designation'=>$user->emp_designation,
                    'status'=>$cur_status->status,
                    'intime' => $cur_status->in_time,
                    'new_data' => $response,
                    'image'=>$user->image]])->header('Access-Control-Expose-Headers', 'auth-token')->header('auth-token',$token);
           }
           else if (Hash::check($password,$user->password) && $user) {

                    $new_user = new Attendances;
                    $new_user->emp_id = $emp_id;
                    $date_time = Carbon::now();
                    $new_user->date =  $date_time->toDateString();
                    $new_user->in_time = $date_time->toTimeString();
                    $InTime = Carbon::parse($new_user->in_time)->format('H:i:s');
                    if($InTime < '09:30:00'){
                        $new_user->status = '1';
                    }
                    else{
                        $new_user->status = '2';
                    }

                    $res = $new_user->save(); // save data into database


                    if(!$res){
                        return ["result"=>" Data not successfully saved in attendance table"];
                    }
                    else{
                           // As  $new_user->status is updated so again search for getting new updated status
                            $cur_status =  Attendances::where('emp_id', $emp_id)->where('date',$cur_date)->first();

                            $token = $user->createToken('web-app')->plainTextToken;
                            return response()->json([
                                'code'=>'4',
                                'message'=>'you are successfully logged in',
                                'data' => [
                                'emp_id' => $user->emp_id,
                                'emp_name'=>$user->name,
                                'email' => $user->email,
                                'designation'=>$user->emp_designation,
                                'status'=>$cur_status->status,
                                'intime'   =>$decision_time,
                                'new_data' => $response,
                                'image'=>$user->image]])->header('Access-Control-Expose-Headers', 'auth-token')->header('auth-token',$token);
                    }
                }
        }

    }

    public function signUp(Request $req)
    {
        $emp = new Employee;
        $emp->name = $req->name;
        $emp->emp_id = $req->emp_id;
        $emp->image = $req->image;  /// this is not exectly right way to store an image
        $emp->password = Hash::make($req->password);
       // $emp_pass = Hash::make($req->password);
        $emp->email = $req->email;
        $emp->date_of_birth = $req->date_of_birth;
        $emp->address = $req->address;
        $emp->joining_date = $req->joining_date;
        $emp->contact_number = $req->contact_number;
        $emp->emp_status = $req->emp_status;
        $emp->emp_designation = $req->emp_designation;
        // if($request->hasfile('image')){
        //     $file = $request->file('image');
        //     $extension = $file->getClientOriginalExtension(); // getting image extension
        //     $filename = time. '.' .$extension;
        //     $file->move('uploads/images',$filename);
        //     $images->image = $filename;
        // }
        // else{
        //     return $request;
        //     $images->image = '';
        // }
        $res = $emp->save();
        if($res){
            return ["result" => "successful"];
        }
        else{
            return ["result" => "unsuccessful"];
        }

    }

    public function userLogin(){
        return view('user-panel.login.login');
    }
}
