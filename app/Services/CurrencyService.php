<?php

namespace App\Services;

use App\Repositories\Currency\CurrencyInterface;


class CurrencyService
{
    public function __construct(
        protected CurrencyInterface $currencyRepository
    ) {
    }

    public function create(array $data)
    {
        return $this->currencyRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->currencyRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->currencyRepository->delete($id);
    }

    public function all()
    {

        return $this->currencyRepository->all();
    }

    public function find($id)
    {
        return $this->currencyRepository->find($id);
    }
}
