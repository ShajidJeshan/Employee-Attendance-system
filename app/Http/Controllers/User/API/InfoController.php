<?php
namespace App\Http\Controllers\User\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\Validator;

class InfoController extends Controller
{
    //Get Info function
    function getInfo($emp_id=NULL){

            //For invalid input
            if (!preg_match('/^[\w.-]*$/', $emp_id) || $emp_id==NULL){
                return response()->json([
                    'code'=> 1,
                    'message'=> 'Invalid Input',
                ]);
            }else{

                //Getting specific employee fields of Employee Model
                $data =  Employee::getData($emp_id);

                if( !$data){

                    //For data not found in database
                    return response()->json([
                        'code'=>2,
                        'message'=>'Data not found',
                    ]);
                }else{

                    //Valid output in JSON format
                    return response()-> json([
                        'code'=>0,
                        'message'=>'OK',
                        'data'=> $data,
                        // 'header'=> $header,
                    ],200);
                }
            }
    }


    //Update Info function
    function updateInfo(Request $req,$emp_id=Null){
        
        //image validation
        // $imgreq = array();
        // $imgreq[0] = $req->image;
        if($req->image!= Null){
            $validator = Validator::make($req->all(),([
                'image' => 'image|mimes:jpeg,png,jpg,html|max:2048',
            ]));
            if($req->image->getClientMimeType()=='image/svg+xml'){
                return response()->json([
                    'code'=> 1,
                    'message'=> 'Invalid Input',
                ]);
            }
            if ($validator->fails()) {
                return response()->json([
                    'code' => '1', 
                    'message' => $validator->errors(),
                ]);
            } 
        }

            //For invalid input
            if (!preg_match('/^[\w.-]*$/', $emp_id) || $emp_id==NULL){
                return response()->json([
                    'code'=> 1,
                    'message'=> 'Invalid Input',
                ]);
            }else{

                //getting specific employee fields
                $data= Employee::getEmployee($emp_id);

                if($data != NULL){
                    //Updating the db
                    Employee::updateEmployee($data,$req);

                    //Valid output in JSON format
                    return response()->json([
                        'code'=>0,
                        'message'=>'OK',
                        'data'=> $data,
                    ],200);
                }else{

                    //For data not found in database
                    return response()->json([
                        'code'=>2,
                        'message'=>'Data not found',
                    ]);
                }
            }
    }
}
