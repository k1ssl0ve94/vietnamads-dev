<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Validator;
use App\Lib\Location;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Location::load();

        Validator::extend('phone_number', function($attribute, $value, $parameters)
        {
            return preg_match("/^[\s\d+\-\(\)]{6,18}$/i", $value);
        });

        Validator::replacer('phone_number', function($message, $attribute, $rule, $parameters) {
            return 'Số điện thoại không hợp lệ';
        });

        Validator::extend('recaptcha', "App\Validators\ReCaptcha@validate");

        Blade::component('components.product_home', 'product_home');
        Blade::component('components.product_map', 'product_map');
        Blade::component('components.product_category', 'product_category');
        Blade::component('components.product_parentcategory', 'product_parentcategory');
        Blade::component('components.post_listing', 'post_listing');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
