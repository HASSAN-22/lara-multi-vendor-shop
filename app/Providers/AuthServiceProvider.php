<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Guarantee;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Property;
use App\Models\Slider;
use App\Models\User;
use App\Policies\BrandPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\GuaranteePolicy;
use App\Policies\ProductPolicy;
use App\Policies\ProfilePolilcy;
use App\Policies\PropertyPolicy;
use App\Policies\SliderPolicy;
use App\Policies\UserPolicy;
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
        Property::class => PropertyPolicy::class,
        User::class => UserPolicy::class,
        Product::class => ProductPolicy::class,
        Profile::class => ProfilePolilcy::class,
        Slider::class => SliderPolicy::class,
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
