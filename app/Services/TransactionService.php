<?php

namespace App\Services;

use App\Repositories\Receipt\ReceiptInterface;
use App\Repositories\Currency\CurrencyInterface;
use App\Repositories\Transaction\TransactionInterface;




class TransactionService
{
    public function __construct(
        protected TransactionInterface $transactionRepository,
        protected CurrencyInterface $currencyRepository,
        protected ReceiptInterface $receiptRepository,
    ) {
    }


    public function all()
    {
        return $this->transactionRepository->all();
    }

    public function find($id)
    {
        return $this->transactionRepository->find($id);
    }

    public function create(array $data)
    {
        $currency = $this->currencyRepository->find($data['currency_id']);
        $data['status'] = 'incomplete';




        if($data['type'] == 'international'){
            $data['rate'] = $currency->rate;

            //Check If Receipt If Has Details
            if(!$this->receiptRepository->checkDetailExist($data['receipt_id'])){
                throw new \Exception('Receipt must be has details.');
            }
        }

        return $this->transactionRepository->create($data);

    }

}
