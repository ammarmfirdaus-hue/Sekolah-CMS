<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeacherAccountRequest;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherAccountController extends Controller
{
    public function store(StoreTeacherAccountRequest $request, Teacher $teacher): RedirectResponse
    {
        abort_if($teacher->user_id !== null, 409, 'Guru sudah memiliki akun.');

        $validated = $request->validated();
        $temporaryPassword = $validated['password'] ?? Str::password(12);

        DB::transaction(function () use ($teacher, $validated, $temporaryPassword): void {
            $user = User::query()->create([
                'name' => $teacher->name,
                'email' => $validated['email'],
                'password' => Hash::make($temporaryPassword),
                'role' => UserRole::TEACHER,
                'is_active' => true,
                'must_change_password' => true,
            ]);

            $teacher->update(['user_id' => $user->id]);
        });

        return redirect()
            ->route('admin.teachers.show', $teacher)
            ->with('status', 'Akun guru berhasil dibuat.')
            ->with('temporary_password', $temporaryPassword);
    }

    public function activate(Teacher $teacher): RedirectResponse
    {
        abort_if($teacher->user === null, 404);

        $teacher->user->update(['is_active' => true]);

        return redirect()
            ->route('admin.teachers.show', $teacher)
            ->with('status', 'Akun guru berhasil diaktifkan.');
    }

    public function deactivate(Teacher $teacher): RedirectResponse
    {
        abort_if($teacher->user === null, 404);

        $teacher->user->update(['is_active' => false]);

        return redirect()
            ->route('admin.teachers.show', $teacher)
            ->with('status', 'Akun guru berhasil dinonaktifkan.');
    }

    public function resetPassword(Teacher $teacher): RedirectResponse
    {
        abort_if($teacher->user === null, 404);

        $temporaryPassword = Str::password(12);

        $teacher->user->update([
            'password' => Hash::make($temporaryPassword),
            'must_change_password' => true,
        ]);

        return redirect()
            ->route('admin.teachers.show', $teacher)
            ->with('status', 'Password sementara berhasil dibuat.')
            ->with('temporary_password', $temporaryPassword);
    }
}
