<?php
namespace App\Repositories\Redemption;




use App\Models\Redemption;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Voucher\VoucherInterface;


class RedemptionRepository implements RedemptionInterface
{
    public function myredemption()
    {
        $userId = Auth::user()->id;
        return Redemption::where('user_id',$userId)->get();
    }

    public function create(array $data)
    {
        return Redemption::create($data);
    }

    public function update(array $data, $id)
    {
        $user = Redemption::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = Redemption::findOrFail($id);
        $user->delete();
    }

    public function find($id)
    {
        return Redemption::findOrFail($id);
    }

    public function findOne(array $data)
    {
        return Redemption::where($data)->firstOrFail();
    }
}
