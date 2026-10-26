<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UpdateSchoolProfileRequest;
use App\Models\SchoolProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SchoolProfileController
{
    public function information(): View
    {
        $schoolProfile = SchoolProfile::query()->first();

        return view('admin.school-profile.information', compact('schoolProfile'));
    }

    public function update(UpdateSchoolProfileRequest $request): RedirectResponse
    {
        $schoolProfile = SchoolProfile::query()->first();
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $oldLogo = $schoolProfile?->logo;
            $logoPath = $request->file('logo')->store('school-profile/logos', 'public');
            $data['logo'] = $logoPath;

            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
        }

        if ($request->hasFile('banner_image')) {
            $oldBanner = $schoolProfile?->banner_image;
            $bannerPath = $request->file('banner_image')->store('school-profile/banners', 'public');
            $data['banner_image'] = $bannerPath;

            if ($oldBanner && Storage::disk('public')->exists($oldBanner)) {
                Storage::disk('public')->delete($oldBanner);
            }
        }

        if ($schoolProfile) {
            $schoolProfile->fill($data);
            $schoolProfile->save();
        } else {
            $schoolProfile = SchoolProfile::query()->create($data);
        }

        return redirect()
            ->route('admin.school-profile.information')
            ->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
