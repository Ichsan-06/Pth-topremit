<?php

namespace App\Services;

use App\Repositories\Voucher\VoucherInterface;




class VoucherService
{
    public function __construct(
        protected VoucherInterface $voucherRepository
    ) {
    }

    public function create(array $data)
    {
        return $this->voucherRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->voucherRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->voucherRepository->delete($id);
    }

    public function all()
    {

        return $this->voucherRepository->all();
    }

    public function find($id)
    {
        return $this->voucherRepository->find($id);
    }
}
