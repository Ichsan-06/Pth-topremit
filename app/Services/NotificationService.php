<?php

namespace App\Services;

use App\Repositories\Notification\NotificationInterface;

class NotificationService
{
    public function __construct(
        protected NotificationInterface $notificationRepository
    ) {
    }

    public function all($request)
    {
        return $this->notificationRepository->all($request);
    }

}
