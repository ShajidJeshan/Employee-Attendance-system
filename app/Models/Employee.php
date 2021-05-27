<?php

namespace App\Models;
use App\Http\Controllers\LogInController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class Employee extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image',
        'emp_id',
        'email',
        'password',
        'date_of_birth',
        'address',
        'joining_date',
        'contact_number',
        'emp_status',
        'emp_designation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Get Employee's specific data
    public static function getData($emp_id){
        $data = DB::table('employees')
                ->select('name', 'image', 'emp_id', 'email', 'date_of_birth', 'address', 'joining_date', 'contact_number', 'emp_status', 'emp_designation')
                ->where('emp_id','=', $emp_id)->first();
        
        return $data;
    }

    //Get Employee's full data 
    public static function getEmployee($emp_id){
        $data = Employee::where('emp_id',$emp_id)
            ->get()->first();
        
        return $data;
    }

    //Update Employee data
    public static function updateEmployee($data,$req){

        if ($req->hasfile('image')) {
            $img= $req->image;
            $prevImg= Str::of($data->image)->afterLast('/');
            if (File::exists('images/' . $prevImg)) {
                File::delete('images/' . $prevImg);
            }
            $image = $data->emp_id. '.' .$img->getClientOriginalExtension();
        
            // $enc =base64_encode(file_get_contents($img->pat‌​h()));
            Image::make($img)->save(public_path('images/'.$image));
            $path = public_path('images\\'.$image);
            $data->image= $path;
            // base64_encode(file_get_contents($request->file('image')->pat‌​h()));
        }
        $data->name = $req->name ? $req->name : $data->name;
        $data->address = $req->address ? $req->address : $data->address;
        $data->contact_number = $req->contact_number ? $req->contact_number : $data->contact_number;
        $data->save();
        
        return $data;
    }


    //Admin Panel Employee Create, Update and Delete
    public static function EmployeeCreate($req)
    {
        $employee = new Employee([
            'name' => $req['name'],
            'image' => $req['image'],
            'emp_id' => $req['emp_id'],
            'email' => $req['email'],
            'password' => $req['password'],
            'date_of_birth' => $req['date_of_birth'],
            'address' => $req['address'],
            'joining_date' => $req['joining_date'],
            'contact_number' => $req['contact_number'],
            'emp_status' => $req['emp_status'],
            'emp_designation' => $req['emp_designation']
        ]);

        $employee->save();
        return $employee;
    }

    public static function getAdminEmployeeInfo($req)
    {
        $data = Employee::where('emp_id', $req['emp_id'])->first();
        
        $data->email = $req['email'] ? $req['email'] : $data->email;
        $data->address = $req['address'] ? $req['address'] : $data->address;
        $data->contact_number = $req['contact_number'] ? $req['contact_number'] : $data->contact_number;
        $data->emp_status = $req['emp_status'] ? $req['emp_status'] : $data->emp_status;
        $data->emp_designation = $req['emp_designation'] ? $req['emp_designation'] : $data->emp_designation;

        $data->save();
       
        return $data->attributes;
    }

    //Admin Delete By Admin
    public static function AdminEmployeeDelete($data)
    {
        $value = Employee::where('name', $data['name'])
                         ->delete();
    }
}
