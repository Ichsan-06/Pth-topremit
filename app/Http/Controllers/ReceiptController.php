<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Helpers\JSONResponse;
use App\Services\ReceiptService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReceiptController extends Controller
{
    public function __construct(
        protected ReceiptService $receiptService
      ) {
      }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receipt = $this->receiptService->all();
        return JSONResponse::send($receipt,'successfully list',200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:local,international',
            'account_name' => 'required|string',
            'account_number' => 'required|integer',

            'details.relationship' => 'required_if:type,==,international|string|in:parent,child,husband,wife,myself,others',
            'details.email' => 'nullable|email',
            'details.province' => 'required_if:type,==,international|string',
            'details.city' => 'required_if:type,==,international|string',
            'details.address' => 'required_if:type,==,international|string',
            'details.postal_code' => 'required_if:type,==,international|string',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $data = $request->toArray();
        $data['user_id'] = Auth::user()->id;
        if($request->type == 'local'){
            unset($data['details']);
            $receipt = $this->receiptService->create($data);
        } else if ($request->type == 'international'){
            $receipt = $this->receiptService->createWithDetail($data);
        } else{
            return JSONResponse::send([],"error with type",403);
        }

        return JSONResponse::send($receipt,"successfully ".__FUNCTION__,200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $receipt = $this->receiptService->find($id);
        } catch (ModelNotFoundException $e) {
            return JSONResponse::send([],'Receipt not found',404);
        } catch (\Exception $e) {
            return JSONResponse::send([],'Internal Server Error',500);
        }

        return JSONResponse::send($receipt,"successfully ".__FUNCTION__,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $receipt = $this->receiptService->delete($id);
        } catch (ModelNotFoundException $e) {
            return JSONResponse::send([],'Receipt not found',404);
        } catch (\Exception $e) {
            return JSONResponse::send([],'Internal Server Error',500);
        }
        return JSONResponse::send($receipt,"successfully ".__FUNCTION__,200);
    }
}
