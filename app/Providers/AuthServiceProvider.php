<?php

// app/Providers/AuthServiceProvider.php
namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User; // Import model User

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Definisikan Gate 'admin'
        Gate::define('admin', function (User $user) {
            return $user->isAdmin(); // Memanggil method isAdmin() dari model User
        });

        // Contoh Gate lain jika diperlukan, misal untuk meminjam buku
        Gate::define('borrow-book', function (User $user) {
            return $user->member && $user->member->role === 'member';
        });
    }
}
