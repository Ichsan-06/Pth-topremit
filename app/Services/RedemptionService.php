<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Voucher\VoucherInterface;
use App\Repositories\Redemption\RedemptionInterface;

class RedemptionService
{
    public function __construct(
        protected RedemptionInterface $redemptionRepository,
        protected VoucherInterface $voucherRepository
    ) {
    }

    public function create(array $data)
    {
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $data['date'] = now();
        $data['is_used'] = false;

        $voucher = $this->voucherRepository->find($data['voucher_id']);

        //check Point Requirement
        if($user->point < $voucher->point_requirement){
            throw new \Exception("Point not enough");
        }

        $redeem = $this->redemptionRepository->create($data);

        //Update Point User
        $user->point -= $voucher->point_requirement;
        $user->save();

        return $redeem;
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
