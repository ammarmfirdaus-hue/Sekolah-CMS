<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrganizationStructureRequest;
use App\Http\Requests\Admin\UpdateOrganizationStructureRequest;
use App\Models\OrganizationStructure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OrganizationStructureController extends Controller
{
    public function index(): View
    {
        $members = OrganizationStructure::query()
            ->ordered()
            ->paginate(10);

        return view('admin.organization-structures.index', compact('members'));
    }

    public function create(): View
    {
        return view('admin.organization-structures.create');
    }

    public function store(StoreOrganizationStructureRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $maxSortOrder = OrganizationStructure::query()->max('sort_order') ?? 0;
        $data['sort_order'] = $maxSortOrder + 1;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('organization-structures', 'public');
        }

        OrganizationStructure::query()->create($data);

        return redirect()
            ->route('admin.organization-structures.index')
            ->with('status', 'Anggota struktur organisasi berhasil ditambahkan.');
    }

    public function edit(OrganizationStructure $organizationStructure): View
    {
        return view('admin.organization-structures.edit', compact('organizationStructure'));
    }

    public function update(UpdateOrganizationStructureRequest $request, OrganizationStructure $organizationStructure): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $oldPhoto = $organizationStructure->photo;
            $data['photo'] = $request->file('photo')->store('organization-structures', 'public');

            if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
                Storage::disk('public')->delete($oldPhoto);
            }
        }

        $organizationStructure->update($data);

        return redirect()
            ->route('admin.organization-structures.index')
            ->with('status', 'Anggota struktur organisasi berhasil diperbarui.');
    }

    public function destroy(OrganizationStructure $organizationStructure): RedirectResponse
    {
        $photo = $organizationStructure->photo;

        $organizationStructure->delete();

        if ($photo && Storage::disk('public')->exists($photo)) {
            Storage::disk('public')->delete($photo);
        }

        return redirect()
            ->route('admin.organization-structures.index')
            ->with('status', 'Anggota struktur organisasi berhasil dihapus.');
    }
}
