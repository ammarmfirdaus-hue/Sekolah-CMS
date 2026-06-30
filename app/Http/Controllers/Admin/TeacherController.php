<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeacherRequest;
use App\Http\Requests\Admin\UpdateTeacherRequest;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $teachers = Teacher::query()
            ->with(['user', 'teacherAssignments.program', 'teacherAssignments.subject'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('position', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($query) => $query->where('email', 'like', "%{$search}%"));
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.teachers.index', compact('teachers', 'search'));
    }

    public function create(): View
    {
        return view('admin.teachers.create');
    }

    public function store(StoreTeacherRequest $request): RedirectResponse
    {
        $teacher = Teacher::query()->create($request->validated());

        return redirect()
            ->route('admin.teachers.show', $teacher)
            ->with('status', 'Data guru berhasil ditambahkan.');
    }

    public function show(Teacher $teacher): View
    {
        $teacher->load(['user', 'teacherAssignments.program', 'teacherAssignments.subject']);

        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher): View
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher): RedirectResponse
    {
        $teacher->update($request->validated());

        return redirect()
            ->route('admin.teachers.show', $teacher)
            ->with('status', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
        DB::transaction(function () use ($teacher): void {
            $teacher->load('user');
            $user = $teacher->user;

            if ($user) {
                $teacher->update(['user_id' => null]);
                $user->delete();
            }

            $teacher->delete();
        });

        return redirect()
            ->route('admin.teachers.index')
            ->with('status', 'Data guru berhasil dihapus.');
    }
}
