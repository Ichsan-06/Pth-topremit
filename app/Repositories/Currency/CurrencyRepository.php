<?php

namespace App\Repositories\Currency;

use App\Models\Currency;
use App\Repositories\Currency\CurrencyInterface;


class CurrencyRepository implements CurrencyInterface
{
    public function all()
    {
        return Currency::all();
    }

    public function create(array $data)
    {
        return Currency::create($data);
    }

    public function update(array $data, $id)
    {
        $user = Currency::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = Currency::findOrFail($id);
        $user->delete();
    }

    public function find($id)
    {
        return Currency::findOrFail($id);
    }
}
