<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Training;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $this->month = now()->format('Y-m');

        return Inertia::render('Dashboard/Index',[
            'employee' => Employee::where('deleted_at', '=', NULL)->count(),
            'training' => Training::where('deleted_at', '=', NULL)->count(),
            'thisMonth' => Training::where('date', 'like', $this->month.'%')->count(),
        ]);
    }
}
