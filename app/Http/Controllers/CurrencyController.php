<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Helpers\JSONResponse;
use App\Services\CurrencyService;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function __construct(
        protected CurrencyService $currencyService
      ) {
      }


    public function index()
    {
        $currency = $this->currencyService->all();
        return JSONResponse::send($currency,'successfully list',200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'country_name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:currencies',
            'rate' => 'required|integer',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $currency = $this->currencyService->create($request->toArray());
        return JSONResponse::send($currency,"successfully ".__FUNCTION__,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,$id)
    {
        $currency = $this->currencyService->find($id);
        return JSONResponse::send($currency,"successfully ".__FUNCTION__,200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {

        try {
            $currency = $this->currencyService->find($id);
        } catch (\Throwable $th) {
            return JSONResponse::send([],"currency not found",200);
        }

        $validator = Validator::make($request->all(), [
            'country_name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:currencies,code,'.$id,
            'rate' => 'required|integer',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }


        $currency = $this->currencyService->update($request->toArray(),$id);
        return JSONResponse::send($currency,"successfully ".__FUNCTION__,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $currency = $this->currencyService->delete($id);
        return JSONResponse::send($currency,"successfully ".__FUNCTION__,200);
    }
}
