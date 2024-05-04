<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Receipt\ReceiptInterface;
use App\Repositories\Voucher\VoucherInterface;
use App\Repositories\Currency\CurrencyInterface;
use App\Repositories\Redemption\RedemptionInterface;
use App\Repositories\Transaction\TransactionInterface;




class TransactionService
{
    public function __construct(
        protected TransactionInterface $transactionRepository,
        protected CurrencyInterface $currencyRepository,
        protected ReceiptInterface $receiptRepository,
        protected VoucherInterface $voucherRepository,
        protected RedemptionInterface $redemptionRepository,
    ) {
    }


    public function all($request)
    {
        return $this->transactionRepository->all($request);
    }

    public function find($id)
    {
        return $this->transactionRepository->find($id);
    }

    public function create(array $data)
    {
        $user = Auth::user();

        //Check If user Not Verified
        if($user->account_verified_at == null){
            throw new \Exception('Please Verified your account');
        }

        $currency = $this->currencyRepository->find($data['currency_id']);
        $data['status'] = 'incomplete';
        $data['sub_amount'] = $data['amount'];

        if($data['type'] == 'international'){
            $data['rate'] = $currency->rate;

            //Check If Receipt If Has Details
            if(!$this->receiptRepository->checkDetailExist($data['receipt_id'])){
                throw new \Exception('Receipt must be has details.');
            }
        }

        //Check If Use Voucher
        if(isset($data['voucher_id']) && ($data['voucher_id'] !== null || $data['voucher_id'] !== '')){

            //Check if user has Reedem Voucher
            try {
                $redemption = $this->redemptionRepository->findOne(['voucher_id' => $data['voucher_id'],'user_id' => $user->id,'is_used'=>0]);
            } catch (\Throwable $th) {
                throw new \Exception("You doesnt Have Voucher");
            }

            $voucher = $this->voucherRepository->find($data['voucher_id']);
            $data['amount'] = $data['amount'] * ($voucher->discount_nominal / 100);

            //Update Redemption Voucher Because Used
            $this->redemptionRepository->update(['is_used' => 1],$redemption->id);
        }

        $transaction =  $this->transactionRepository->create($data);

        return $transaction;

    }

}
