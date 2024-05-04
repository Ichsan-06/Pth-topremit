<?php
namespace App\Repositories\Transaction;




use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Transaction\TransactionInterface;


class TransactionRepository implements TransactionInterface
{
    public function all($request)
    {
        $perPage = $request->filled('per_page') ? $request->per_page : 20;
        $user = Auth::user();
        $query =  Transaction::with('receipt',
        'currency',
        'payment')->where('user_id',$user->id)->order($request)->filter($request);


        return $query->paginate($perPage);
    }

    public function create(array $data)
    {
        return Transaction::create($data);
    }

    public function find($id)
    {
        return Transaction::with('receipt','currency')->findOrFail($id);
    }

    public function findOne(array $data)
    {
        return Transaction::where($data)->firstOrFail();
    }

    public function update(array $data, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($data);
        return $transaction;
    }
}
