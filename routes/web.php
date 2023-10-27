<?php

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use function Laravel\Prompts\search;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    $selectedDate = $request->query('date')
        ? Carbon::parse($request->input('date'))
        : Carbon::now();

    $weekNumber = $selectedDate->weekOfYear;
    $weekStartDate = $selectedDate->startOfWeek()->format('d/m');
    $weekEndDate = $selectedDate->endOfWeek()->format('d/m');

    $data = [
        'weekNumber' => $weekNumber,
        'startDate' => $weekStartDate,
        'endDate' => $weekEndDate,
    ];

    if ($request->query('date')) {
        $data['filters'] = ['date' => $request->query('date')];
    }

    return Inertia::render('Home', ['data' => $data]);
})->name('home');

Route::post('/employees', function (Request $request) {
    $attributes = $request->validate([
        'firstname' => 'required|string|min:2|max:30',
        'lastname' => 'required|string|min:2|max:30'
    ]);

    Employee::create($attributes);
});
