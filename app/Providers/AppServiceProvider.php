<?php

namespace App\Providers;

use App\Services\PaymentService;
use App\Services\ReceiptService;
use App\Services\VoucherService;
use App\Services\CurrencyService;
use App\Services\RedemptionService;
use App\Services\TransactionService;
use App\Services\NotificationService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Payment\PaymentInterface;
use App\Repositories\Receipt\ReceiptInterface;
use App\Repositories\Voucher\VoucherInterface;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Receipt\ReceiptRepository;
use App\Repositories\Voucher\VoucherRepository;
use App\Repositories\Currency\CurrencyInterface;
use App\Repositories\Currency\CurrencyRepository;
use App\Repositories\Redemption\RedemptionInterface;
use App\Repositories\Redemption\RedemptionRepository;
use App\Repositories\Transaction\TransactionInterface;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Notification\NotificationInterface;
use App\Repositories\Notification\NotificationRepository;

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
            return new RedemptionService(
                $app->make(RedemptionInterface::class),
                $app->make(VoucherInterface::class),
            );
        });

        $this->app->bind(ReceiptInterface::class, ReceiptRepository::class);
        $this->app->bind(ReceiptService::class, function ($app) {
            return new ReceiptService($app->make(ReceiptInterface::class));
        });

        $this->app->bind(TransactionInterface::class, TransactionRepository::class);
        $this->app->bind(TransactionService::class, function ($app) {
            return new TransactionService(
                $app->make(TransactionInterface::class),
                $app->make(CurrencyInterface::class),
                $app->make(ReceiptInterface::class),
                $app->make(VoucherInterface::class),
                $app->make(RedemptionInterface::class),
            );
        });

        $this->app->bind(PaymentInterface::class, PaymentRepository::class);
        $this->app->bind(PaymentService::class, function ($app) {
            return new PaymentService(
                $app->make(PaymentInterface::class),
                $app->make(TransactionInterface::class)
            );
        });

        $this->app->bind(NotificationInterface::class, NotificationRepository::class);
        $this->app->bind(NotificationService::class, function ($app) {
            return new NotificationService(
                $app->make(NotificationInterface::class),
            );
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
