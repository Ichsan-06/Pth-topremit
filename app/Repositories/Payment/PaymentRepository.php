<?php
namespace App\Repositories\Payment;

use App\Models\Payment;
use App\Repositories\Payment\PaymentInterface;


class PaymentRepository implements PaymentInterface
{
    public function all()
    {
        return Payment::all();
    }

    public function create(array $data)
    {
        return Payment::create($data);
    }

    public function find($id)
    {
        return Payment::with()->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $paymet = Payment::findOrFail($id);
        $paymet->update($data);
        return $paymet;
    }
}
