<?php

namespace App\Repositories\Currency;

interface CurrencyInterface
{
    public function all($request);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id);
}
