<?php

namespace App\Http\Requests\Admin;

use App\Models\TeacherAssignment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeacherAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $teacherId = $this->route('teacher')?->id;

        return [
            'program_id' => ['required', 'integer', 'exists:programs,id'],
            'subject_id' => [
                'required',
                'integer',
                'exists:subjects,id',
                Rule::unique(TeacherAssignment::class, 'subject_id')
                    ->where('teacher_id', $teacherId)
                    ->where('program_id', $this->input('program_id')),
            ],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'subject_id.unique' => 'Assignment guru untuk program dan mata pelajaran tersebut sudah tersedia.',
        ];
    }
}
