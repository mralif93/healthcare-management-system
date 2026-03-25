<?php

namespace App\Providers;

use App\Models\Setting;
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
        // Share clinic name from DB settings to all layouts
        View::composer(
            ['layouts.admin', 'layouts.staff', 'layouts.doctor', 'layouts.public'],
            function ($view) {
                try {
                    $clinicName = Setting::get('app_name', config('app.name', 'Clinic OS'));
                } catch (\Exception $e) {
                    $clinicName = config('app.name', 'Clinic OS');
                }
                $view->with('clinicName', $clinicName);
            }
        );
    }
}
