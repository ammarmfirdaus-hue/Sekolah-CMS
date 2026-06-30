<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeacherAssignmentRequest;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeacherAssignmentController extends Controller
{
    public function create(Teacher $teacher): View
    {
        $programs = Program::query()->orderBy('sort_order')->orderBy('name')->get();
        $subjects = Subject::query()->orderBy('name')->get();

        return view('admin.teachers.assignments.create', compact('teacher', 'programs', 'subjects'));
    }

    public function store(StoreTeacherAssignmentRequest $request, Teacher $teacher): RedirectResponse
    {
        $teacher->teacherAssignments()->create($request->validated());

        return redirect()
            ->route('admin.teachers.show', $teacher)
            ->with('status', 'Assignment guru berhasil ditambahkan.');
    }

    public function destroy(Teacher $teacher, TeacherAssignment $assignment): RedirectResponse
    {
        abort_unless($assignment->teacher_id === $teacher->id, 404);

        $assignment->delete();

        return redirect()
            ->route('admin.teachers.show', $teacher)
            ->with('status', 'Assignment guru berhasil dihapus.');
    }
}
