<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Teacher;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $totalTeachers = Teacher::query()->count();
        $totalTeacherAccounts = Teacher::query()->whereNotNull('user_id')->count();
        $teachersWithoutAccounts = Teacher::query()->whereNull('user_id')->count();
        $totalPrograms = Program::query()->count();

        $latestTeachers = Teacher::query()
            ->with(['user', 'teacherAssignments.program', 'teacherAssignments.subject'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalTeachers',
            'totalTeacherAccounts',
            'teachersWithoutAccounts',
            'totalPrograms',
            'latestTeachers'
        ));
    }
}
