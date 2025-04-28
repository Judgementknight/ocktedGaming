<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade; // Add this import
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // if (env('APP_ENV') !== 'local') {
        //     URL::forceScheme('https');
        // }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the Blade directive inside the boot method
        Blade::directive('notify', function () {
            return '<?php if(session("notify")): ?>
                <script>
                    window.notyf?.<?= session("notify")["type"] ?>(\'<?= addslashes(session("notify")["message"]) ?>\')
                </script>
            <?php endif; ?>';
        });
    }
}
