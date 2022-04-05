<?php

namespace App\Providers;

use App\Models\UserCustomer;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('edit-feedback', function ($user, $feedback) {
            return $user->id === $feedback->workout()->first()->assigned_to;
        });

        Gate::define('assign-workout', function ($user, $assignee) {
            $customer = UserCustomer::where('user_id', $user->id)->where('customer_id', $assignee)->first();
            return !empty($customer);
        });

    }
}
