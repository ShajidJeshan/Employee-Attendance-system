<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCreation extends Model
{
    use HasFactory;

    protected $fillable = [
            'name',
            'email',
            'gender',
            'employee_id',
            'mobile_number',
            'address',
            'password',
            'confirm_password',
            'join_date',
            'designation',
            'department',
            'leave_policy',
            'employment_type',
            'shift_group',
            'workplace'
    ];

    public static function AdminEmployeeCreation($req){

        $employee = new EmployeeCreation([
            'name' => $req['name'],
            'email' => $req['email'],
            'gender'=> $req['gender'],
            'emp_id' => $req['employee_id'],
            'mobile_number' => $req['mobile_number'],
            'address' => $req['address'],
            'password'=> $req['password'],
            'confirm_password'=> $req['confirm_password'],
            'join_date' => $req['join_date'],
            'designation'=> $req['designation'],
            'department' => $req['department'],
            'role' => $req['role'],
            'leave_policy'=> $req['leave_policy'],
            'employment_type'=> $req['employment_type'],
            'shift_group' => $req['shift_group'],
            'workplace' => $req['workplace']
        ]);

        $employee->save();
        return $employee;
    }

   public static function AdminEmployeeSearch($req){

   }
}
