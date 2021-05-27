<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeManageController extends Controller
{
    public function __construct()
    {
        // config(['app.timezone' => 'Asia/Dhaka']);

    }

    public function index(){
        return view('admin-panel.employees.index');
    }

    public function createEmployee(){
        return view('admin-panel.employees.create');
    }

    public function editEmployee(){
        return view('admin-panel.employees.edit');
    }

    public function showEmployeeProfile(){
        return view('admin-panel.employees.profile');
    }
}
