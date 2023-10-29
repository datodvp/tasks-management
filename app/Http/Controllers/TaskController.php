<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Week;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'task_type' => 'required|in:projects,quotes,regular,trainings,unplanned',
            'task_name' => 'required|string|min:2',
            'task_product' => 'nullable',
            'planned_time' => 'nullable',
            'actual_time' => 'nullable',
            'completion_time' => 'nullable|date_format:Y-m-d',
            'selected_employee_id' => 'required',
            'selected_date' => 'required|date_format:Y-m-d'
        ]);

        $attributes['employee_id'] = $request->input('selected_employee_id');
        $attributes['week_number'] = Carbon::parse($attributes['selected_date'])->weekOfYear;

        $week = Week::where('week_number', $attributes['week_number'])->first();

        if (!$week) {
            $selectedDate = $attributes['selected_date']
                ? Carbon::parse($attributes['selected_date'])
                : Carbon::now();

            $newWeek = [
                'week_number' => $selectedDate->weekOfYear,
                'year' => $selectedDate->year,
                'start_date' => $selectedDate->startOfWeek(),
                'end_date' => $selectedDate->endOfWeek(),
            ];

            $week = Week::create($newWeek);
        }

        $newTask = [
            'task_type' => $attributes['task_type'],
            'task_name' => $attributes['task_name'],
            'task_product' => $attributes['task_product'],
            'planned_time' => $attributes['planned_time'],
            'actual_time' => $attributes['actual_time'],
            'completion_time' => $attributes['completion_time'],
            'employee_id' => $attributes['employee_id'],
            'week_id' => $week['id']
        ];

        $task = Task::create($newTask);

        return redirect()->back();
    }

    public function update(Request $request, Task $task)
    {
        $attributes = $request->validate([
            // this is for task inputs
            'task_type' => 'required|in:projects,quotes,regular,trainings,unplanned',
            'task_name' => 'required|string|min:2',
            'task_product' => 'nullable',
            'planned_time' => 'nullable',
            'actual_time' => 'nullable',
            'completion_time' => 'nullable|date_format:Y-m-d',
        ]);

        $task->update($attributes);

        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->back();
    }
}
