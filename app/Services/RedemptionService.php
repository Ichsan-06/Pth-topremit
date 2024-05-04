<?php

namespace App\Services;

use App\Repositories\Redemption\RedemptionInterface;

class RedemptionService
{
    public function __construct(
        protected RedemptionInterface $redemptionRepository
    ) {
    }

    public function create(array $data)
    {
        return $this->redemptionRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->redemptionRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->redemptionRepository->delete($id);
    }

    public function myredemption()
    {

        return $this->redemptionRepository->myredemption();
    }

    public function find($id)
    {
        return $this->redemptionRepository->find($id);
    }
}
