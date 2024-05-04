<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Helpers\JSONResponse;
use App\Services\CurrencyService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CurrencyController extends Controller
{
    public function __construct(
        protected CurrencyService $currencyService
      ) {
      }


    public function index(Request $request)
    {
        $currency = $this->currencyService->all($request);
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

        try {
            $currency = $this->currencyService->find($id);
        } catch (ModelNotFoundException $e) {
            return JSONResponse::send([],'Currency not found',404);
        } catch (\Exception $e) {
            return JSONResponse::send([],'Internal Server Error',500);
        }

        return JSONResponse::send($currency,"successfully ".__FUNCTION__,200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {

        $validator = Validator::make($request->all(), [
            'country_name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:currencies,code,'.$id,
            'rate' => 'required|integer',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }


        try {
            $currency = $this->currencyService->update($request->toArray(),$id);
        } catch (ModelNotFoundException $e) {
            return JSONResponse::send([],'Currency not found',404);
        } catch (\Exception $e) {
            return JSONResponse::send([],'Internal Server Error',500);
        }

        return JSONResponse::send($currency,"successfully ".__FUNCTION__,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {
            $currency = $this->currencyService->delete($id);
        } catch (ModelNotFoundException $e) {
            return JSONResponse::send([],'Currency not found',404);
        } catch (\Exception $e) {
            return JSONResponse::send([],'Internal Server Error',500);
        }

        return JSONResponse::send($currency,"successfully ".__FUNCTION__,200);
    }
}
