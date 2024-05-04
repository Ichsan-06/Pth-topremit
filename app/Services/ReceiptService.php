<?php

namespace App\Services;

use App\Repositories\Receipt\ReceiptInterface;


class ReceiptService
{
    public function __construct(
        protected ReceiptInterface $receiptRepository
    ) {
    }

    public function create(array $data)
    {
        return $this->receiptRepository->create($data);
    }

    public function createWithDetail(array $data)
    {
        return $this->receiptRepository->createWithDetail($data);
    }

    public function update(array $data, $id)
    {
        return $this->receiptRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->receiptRepository->delete($id);
    }

    public function all()
    {

        return $this->receiptRepository->all();
    }

    public function find($id)
    {
        return $this->receiptRepository->find($id);
    }
}
