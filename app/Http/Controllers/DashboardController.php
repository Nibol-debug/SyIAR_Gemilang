<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Models\Program;
use App\Models\AcademicClass;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Material;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_users' => User::count(),
            'total_branches' => Branch::count(),
            'total_programs' => Program::count(),
            'total_classes' => AcademicClass::where('status', 'active')->count(),
            'total_subjects' => Subject::count(),
            'total_schedules' => Schedule::count(),
            'total_peserta' => User::where('role', 'peserta')->count(),
            'total_instruktur' => User::where('role', 'instruktur')->count(),
            'total_materials' => Material::count(),
        ];

        // Role-specific data
        if ($user->role === 'peserta') {
            $stats['my_grades'] = Grade::where('user_id', $user->id)->avg('score');
            $stats['my_attendances'] = Attendance::where('user_id', $user->id)
                ->where('status', 'hadir')->count();
            $stats['my_total_attendances'] = Attendance::where('user_id', $user->id)->count();
        }

        if ($user->role === 'instruktur') {
            $stats['my_schedules'] = Schedule::where('instructor_id', $user->id)->count();
        }

        return view('dashboard', compact('stats'));
    }
}
