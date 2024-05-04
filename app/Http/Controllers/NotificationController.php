<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Helpers\JSONResponse;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationService $notificationService
      ) {
      }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $receipt = $this->notificationService->all($request);
        return JSONResponse::send($receipt,'successfully list',200);
    }

}
