<?php

namespace App\Providers;

use App\Services\VoucherService;
use App\Services\CurrencyService;
use App\Services\RedemptionService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Voucher\VoucherInterface;
use App\Repositories\Voucher\VoucherRepository;
use App\Repositories\Currency\CurrencyInterface;
use App\Repositories\Currency\CurrencyRepository;
use App\Repositories\Redemption\RedemptionInterface;
use App\Repositories\Redemption\RedemptionRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CurrencyInterface::class, CurrencyRepository::class);
        $this->app->bind(CurrencyService::class, function ($app) {
            return new CurrencyService($app->make(CurrencyInterface::class));
        });

        $this->app->bind(VoucherInterface::class, VoucherRepository::class);
        $this->app->bind(VoucherService::class, function ($app) {
            return new VoucherService($app->make(VoucherInterface::class));
        });

        $this->app->bind(RedemptionInterface::class, RedemptionRepository::class);
        $this->app->bind(RedemptionService::class, function ($app) {
            return new RedemptionService($app->make(RedemptionInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
