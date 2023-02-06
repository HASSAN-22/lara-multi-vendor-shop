<?php

namespace App\Providers;

use Coupon\Coupon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength('191');
        Paginator::useBootstrap();
        $this->connectToDbForCoupon();
    }

    /**
     * @return void
     */
    private function connectToDbForCoupon(): void
    {
        $host = config('database.connections.mysql.host');
        $dbbmae = config('database.connections.mysql.database');
        $user = config('database.connections.mysql.username');
        $pass = config('database.connections.mysql.password');
        Coupon::setDbInfo("mysql:host=$host;dbname=$dbbmae;charset:utf-8", $user, $pass);
    }
}
