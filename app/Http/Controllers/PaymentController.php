<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Helpers\JSONResponse;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\PaymentController;

class PaymentController extends Controller
{

    public function __construct(
        protected PaymentService $paymentService
      ) {
      }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_type' => 'required|string|in:virtual_account,bank_transfer',
            'bank_name' => 'required|string',
            'transaction_id' => 'required|integer|exists:transactions,id',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        try {
            $data = $request->toArray();
            $payment = $this->paymentService->create($data);
        } catch (ModelNotFoundException $e) {
            return JSONResponse::send([],'Currency not found',404);
        } catch (\Exception $e) {
            return JSONResponse::send([],$e->getMessage(),500);
        }

        return JSONResponse::send($payment,"successfully ".__FUNCTION__,200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function listener(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reference_id' => 'required|string',
            'status' => 'required|string|in:pending,success,expired',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        try {
            $payment = $this->paymentService->listener($request->toArray());
        } catch (\Exception $e) {
            return JSONResponse::send([],$e->getMessage(),500);
        }

        return JSONResponse::send($payment,"successfully ".__FUNCTION__,200);
    }
}
