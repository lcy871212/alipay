<?php

namespace Lcy\Alipay;

use Illuminate\Support\ServiceProvider;

class AlipayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       // $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'lcy-alipay');
        $this->app->bind('alipay.web',function($app){
            $alipay = new Web\SdkPayment();
            $alipay->setAppid(ENV('ALIPAY_appId'))
            ->setAppPrivateKey(ENV('ALIPAY_rsaPrivateKey'))
            ->setAppPublicKey(ENV('ALIPAY_alipayrsaPublicKey'))            
            ;
            return $alipay;            
        });
    }

   /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'alipay.web',
        ];
    }

}
