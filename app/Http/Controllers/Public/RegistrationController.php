<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\RegistrationInformation;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(): View
    {
        $registrationInfo = RegistrationInformation::query()->first();

        return view('public.registration.index', compact('registrationInfo'));
    }
}
