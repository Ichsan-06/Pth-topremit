<?php

namespace App\Repositories\Currency;

use App\Models\Currency;
use App\Repositories\Currency\CurrencyInterface;


class CurrencyRepository implements CurrencyInterface
{
    public function all($request)
    {
        $perPage = $request->filled('per_page') ? $request->per_page : 20;
        $query =  Currency::order($request)->filter($request);


        return $query->paginate($perPage);
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
