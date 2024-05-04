<?php
namespace App\Repositories\Payment;


interface PaymentInterface
{
    public function all();

    public function create(array $data);

    public function find($id);

    public function update(array $data, $id);
}
