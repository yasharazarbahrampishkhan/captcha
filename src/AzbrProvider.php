<?php

namespace Azarbahram\Captcha;

use Illuminate\Support\ServiceProvider;
use Azarbahram\Captcha\Azbrcaptcha;

class AzbrProvider extends ServiceProvider
{

    public function register(){

        
        $this->app->bind('azbr',function(){ return new Azbrcaptcha;});

        $this->mergeConfigFrom(__DIR__.'/configs/azrbcaptcha.php','AzrbcaptchaConfig');

    }

    public function boot(){


        $this->publishes([

            __DIR__.'/configs/azrbcaptcha.php' => config_path('azrbcaptcha.php'),

        ]);

    }




}