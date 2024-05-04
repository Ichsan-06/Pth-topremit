<?php

namespace App\Http\Controllers;

use App\Models\Redemption;
use Illuminate\Http\Request;
use App\Helpers\JSONResponse;
use App\Services\RedemptionService;
use Illuminate\Support\Facades\Validator;

class RedemptionController extends Controller
{
    public function __construct(
        protected RedemptionService $redemptionService
      ) {
      }


    /**
     * Display a listing of the resource.
     */
    public function myredemption()
    {
        $redemption = $this->redemptionService->myredemption();
        return JSONResponse::send($redemption,"successfully ".__FUNCTION__,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|max:255|exists:users,id',
            'voucher_id' => 'required|integer|exists:vouchers,id',
            'date' => 'required|date',
            'is_used' => 'required|boolean',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $redemption = $this->redemptionService->create($request->toArray());
        return JSONResponse::send($redemption,"successfully ".__FUNCTION__,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Redemption $redemption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Redemption $redemption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Redemption $redemption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Redemption $redemption)
    {
        //
    }
}
