<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use App\Repositories\Payment\PaymentInterface;
use App\Repositories\Receipt\ReceiptInterface;
use App\Repositories\Currency\CurrencyInterface;
use App\Repositories\Transaction\TransactionInterface;

class PaymentService
{
    public function __construct(
        protected PaymentInterface $paymentRepository,
        protected TransactionInterface $transactionRepository
    ) {
    }


    public function listener(array $data)
    {
        //Check Transaction
        try {
            $transaction = $this->transactionRepository->findOne([
                'reference_id' => $data['reference_id']
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

        //Check If Payment Has Sucess
        if($transaction->payment->status == 'success'){
            throw new \Exception('Payment has been success.');
        }

        //Check Expired
        if($transaction->payment->expired_at < now()){
            throw new \Exception('Payment Has Expired.');
        }

        //Update Transaction
        $this->transactionRepository->update(['status' => $data['status']],$transaction->id);
        $this->paymentRepository->update(['status' => $data['status']],$transaction->payment->id);


        //Add Point User
        if($data['status'] == 'success'){
            $user = User::findOrFail($transaction->user_id);
            $user->point += 100;
            $user->save();

            //Create Notification for User
            $notification = Notification::create([
                'user_id' => $user->id,
                'title' => 'Transaction Success',
                'message' => 'Your Transaction Has Been Success',
            ]);
        }

        return $transaction;

    }

    public function create(array $data)
    {
        $transaction = $this->transactionRepository->find($data['transaction_id']);

        //Check If Has Exist Payment
        if($transaction->payment){
            throw new \Exception('Transaction has been payment.');
        }

        $data['total_amount'] = $transaction->amount;
        $data['fee'] = $transaction->fee;
        $data['status'] = 'pending';

        $payment = $this->paymentRepository->create($data);

        //Update Transaction TO Need Payment
        $this->transactionRepository->update(
            ['status' => 'need_payment'],
            $transaction->id
        );

        return $payment;
    }

}
