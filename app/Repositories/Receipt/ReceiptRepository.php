<?php
namespace App\Repositories\Receipt;



use App\Models\Receipt;
use App\Models\ReceiptDetail;
use App\Repositories\Receipt\ReceiptInterface;


class ReceiptRepository implements ReceiptInterface
{
    public function all()
    {
        return Receipt::with(['receiptDetails' => function ($query) {
            $query->select('id','receipt_id','email', 'province', 'city', 'address', 'postal_code');
        }])->get();
    }

    public function create(array $data)
    {
        return Receipt::create($data);
    }

    public function createWithDetail(array $data)
    {
        $receipt = new Receipt;
        $receipt->fill($data);
        $receipt->save();

        $receipt_detail = new ReceiptDetail;
        $receipt_detail->fill($data['details']);
        $receipt_detail->receipt_id = $receipt->id;
        $receipt_detail->save();

        return $receipt;
    }

    public function update(array $data, $id)
    {
        $user = Receipt::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = Receipt::findOrFail($id);
        $user->delete();
    }

    public function find($id)
    {
        return Receipt::findOrFail($id);
    }

    public function checkDetailExist($id)
    {
        $receipt =  Receipt::findOrFail($id);

        return $receipt->receiptDetails()->exists();
    }
}
