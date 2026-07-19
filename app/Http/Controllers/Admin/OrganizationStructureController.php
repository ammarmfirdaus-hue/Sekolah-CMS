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


}
