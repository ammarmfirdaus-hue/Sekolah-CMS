<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ContentSection;
use App\Models\OrganizationStructure;
use App\Models\Program;
use App\Models\SchoolProfile;
use App\Models\Teacher;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $schoolProfile = SchoolProfile::query()->first();

        $sections = ContentSection::query()
            ->where('is_active', true)
            ->whereIn('section_key', ['profil', 'visi', 'misi', 'sejarah'])
            ->orderBy('sort_order')
            ->get()
            ->keyBy('section_key');

        $programs = Program::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $teachers = Teacher::query()
            ->where('is_active', true)
            ->with([
                'teacherAssignments.subject',
                'teacherAssignments.program',
            ])
            ->orderBy('name')
            ->limit(6)
            ->get();

        $organizationStructures = OrganizationStructure::query()
            ->active()
            ->ordered()
            ->get();

        return view('public.home', compact(
            'schoolProfile',
            'sections',
            'programs',
            'teachers',
            'organizationStructures'
        ));
    }
}
