<?php
namespace App\Repositories\Transaction;



interface TransactionInterface
{
    public function all();

    public function create(array $data);

    public function find($id);
}
