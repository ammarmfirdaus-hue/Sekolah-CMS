<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UpdateRegistrationInformationRequest;
use App\Models\RegistrationInformation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegistrationInformationController
{
    public function information(): View
    {
        $registrationInfo = RegistrationInformation::query()->first();

        return view('admin.registration.information', compact('registrationInfo'));
    }

    public function update(UpdateRegistrationInformationRequest $request): RedirectResponse
    {
        $registrationInfo = RegistrationInformation::query()->first();
        $data = $request->validated();

        if ($registrationInfo) {
            $registrationInfo->fill($data);
            $registrationInfo->save();
        } else {
            RegistrationInformation::query()->create($data);
        }

        return redirect()
            ->route('admin.registration.information')
            ->with('status', 'Informasi pendaftaran berhasil diperbarui.');
    }
}
