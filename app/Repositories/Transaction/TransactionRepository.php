<?php
namespace App\Repositories\Transaction;




use App\Models\Transaction;
use App\Repositories\Transaction\TransactionInterface;


class TransactionRepository implements TransactionInterface
{
    public function all()
    {
        return Transaction::all();
    }

    public function create(array $data)
    {
        return Transaction::create($data);
    }

    public function find($id)
    {
        return Transaction::with('receipt','currency')->findOrFail($id);
    }
}
