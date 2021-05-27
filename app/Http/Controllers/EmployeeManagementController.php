<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeManagementController extends Controller
{
    public function index () {
        return view('user-panel.create-employee.create-employee');
    }
}
