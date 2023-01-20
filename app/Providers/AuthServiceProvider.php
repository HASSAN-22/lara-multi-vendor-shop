<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Guarantee;
use App\Policies\BrandPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\GuaranteePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Brand::class => BrandPolicy::class,
        Guarantee::class => GuaranteePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
