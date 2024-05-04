<?php
namespace App\Repositories\Transaction;



interface TransactionInterface
{
    public function all($request);

    public function create(array $data);

    public function find($id);

    public function findOne(array $data);

    public function update(array $data, $id);
}
