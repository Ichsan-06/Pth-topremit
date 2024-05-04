<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Helpers\JSONResponse;
use App\Services\VoucherService;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    public function __construct(
        protected VoucherService $voucherService
      ) {
      }

    public function index()
    {
        $voucher = $this->voucherService->all();
        return JSONResponse::send($voucher,'successfully list',200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'discount_nominal' => 'required|integer',
            'point_requirement' => 'required|integer',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $voucher = $this->voucherService->create($request->toArray());
        return JSONResponse::send($voucher,"successfully ".__FUNCTION__,200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $voucher = $this->voucherService->find($id);
        return JSONResponse::send($voucher,"successfully ".__FUNCTION__,200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $voucher = $this->voucherService->find($id);
        } catch (\Throwable $th) {
            return JSONResponse::send([],"voucher not found",200);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'discount_nominal' => 'required|integer',
            'point_requirement' => 'required|integer',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }


        $voucher = $this->voucherService->update($request->toArray(),$id);
        return JSONResponse::send($voucher,"successfully ".__FUNCTION__,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $voucher = $this->voucherService->delete($id);
        return JSONResponse::send($voucher,"successfully ".__FUNCTION__,200);
    }
}
