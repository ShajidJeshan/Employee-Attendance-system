<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendances;

class employeeListController extends Controller
{
    public function showList(){
        $user = Employee::paginate(4);
        return ["res"=> $user];
    }
}
