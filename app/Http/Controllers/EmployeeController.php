<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'firstname' => 'required|string|min:2|max:30',
            'lastname' => 'required|string|min:2|max:30'
        ]);

        $employee = Employee::create($attributes);

        return redirect()->back();
    }
}
