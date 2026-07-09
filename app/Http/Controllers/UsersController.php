<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function employees(){
        $employees = User::latest()->get();
        return view('admin.users.employees',[
            'employees'=>$employees,
        ]);
    }
}
