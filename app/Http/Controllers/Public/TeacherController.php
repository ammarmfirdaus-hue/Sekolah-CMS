<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Models\Teacher;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function show(string $slug): View
    {
        $schoolProfile = SchoolProfile::query()->first();

        $teacher = Teacher::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'teacherAssignments.subject',
                'teacherAssignments.program',
            ])
            ->firstOrFail();

        return view('public.teachers.show', compact('schoolProfile', 'teacher'));
    }
}
