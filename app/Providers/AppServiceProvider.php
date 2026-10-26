<?php

namespace App\Providers;

use App\Models\SchoolProfile;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('public.layouts.app', function ($view) {
            $schoolProfile = SchoolProfile::query()->first();
            $schoolName = $schoolProfile?->school_name ?? 'Sekolah';
            $homeUrl = route('home');

            $view->with(compact('schoolProfile', 'schoolName', 'homeUrl'));
        });
    }
}
