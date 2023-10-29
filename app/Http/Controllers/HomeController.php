<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->query('selected_date')
            ? Carbon::parse($request->input('selected_date'))
            : Carbon::now();

        // dd($selectedEmployee);
        $weekNumber = $selectedDate->weekOfYear;
        $weekStartDate = $selectedDate->copy()->startOfWeek()->format('d/m');
        $weekEndDate = $selectedDate->copy()->endOfWeek()->format('d/m');

        $selectedEmployee = Employee::find($request->query('selected_employee_id')) ?? Employee::first();
        if ($selectedEmployee) {
            $tasksOfWeek = $selectedEmployee->tasks()
                ->whereHas('week', function ($query) use ($weekNumber) {
                    $query->where('week_number', $weekNumber);
                })
                ->get();
        }


        $data = [
            'selected_date' => $selectedDate->format('Y-m-d'),
            'selected_employee_id' => $selectedEmployee->id ?? null,
            'startDate' => $weekStartDate,
            'endDate' => $weekEndDate,
            'tasks_of_week' => $tasksOfWeek ?? null,
            'employeesList' => Employee::all()
        ];

        if ($request->query('date')) {
            $data['filters'] = ['date' => $request->query('date')];
        }

        return Inertia::render('Home', ['data' => $data]);
    }
}
