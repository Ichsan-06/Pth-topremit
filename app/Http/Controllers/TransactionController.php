<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\JSONResponse;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
      ) {
      }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:local,international',
            // 'status' => 'required|string|in:incomplete,need_payment,in_progress,success,failed,canceled,expired',
            'receipt_id' => 'required|integer|exists:receipts,id',
            'currency_id' => 'required|integer|exists:currencies,id',
            'rate' => 'nullable|integer',
            'amount' => 'required|integer',
            'fee' => 'required|integer',
            'notes' => 'nullable|string',

        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        try {
            $transaction = $this->transactionService->create($request->toArray());
        } catch (ModelNotFoundException $e) {
            return JSONResponse::send([],'Currency not found',404);
        } catch (\Exception $e) {
            return JSONResponse::send([],$e->getMessage(),500);
        }

        return JSONResponse::send($transaction,"successfully ".__FUNCTION__,200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $receipt = $this->transactionService->find($id);
        } catch (ModelNotFoundException $e) {
            return JSONResponse::send([],'Transaction not found',404);
        } catch (\Exception $e) {
            return JSONResponse::send([],'Internal Server Error',500);
        }

        return JSONResponse::send($receipt,"successfully ".__FUNCTION__,200);
    }
}
