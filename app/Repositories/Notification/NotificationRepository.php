<?php
namespace App\Repositories\Notification;



use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Notification\NotificationInterface;


class NotificationRepository implements NotificationInterface
{
    public function all($request)
    {
        $perPage = $request->filled('per_page') ? $request->per_page : 20;
        $user = Auth::user();
        $query =  Notification::where('user_id',$user->id)->order($request)->filter($request);


        return $query->paginate($perPage);
        // return Notification::all();
    }
}
