<?php
namespace App\Repositories\Voucher;



use App\Models\Voucher;
use App\Repositories\Voucher\VoucherInterface;


class VoucherRepository implements VoucherInterface
{
    public function all()
    {
        return Voucher::all();
    }

    public function create(array $data)
    {
        return Voucher::create($data);
    }

    public function update(array $data, $id)
    {
        $user = Voucher::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = Voucher::findOrFail($id);
        $user->delete();
    }

    public function find($id)
    {
        return Voucher::findOrFail($id);
    }

    public function findOne(array $data)
    {
        return Voucher::where($data)->firstOrFail();
    }
}
