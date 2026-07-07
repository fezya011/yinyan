<?php
// app/Services/LeadNotificationService.php

namespace App\Services;

use App\Mail\NewLeadNotification;
use App\Models\Lead;
use App\Models\NotificationEmail;
use Illuminate\Support\Facades\Mail;

class LeadNotificationService
{
    public function notify(Lead $lead): void
    {
        $recipients = NotificationEmail::active()->get();

        if ($recipients->isEmpty()) {
            return;
        }

        foreach ($recipients as $recipient) {
            Mail::to($recipient->email)
                ->send(new NewLeadNotification($lead));
        }
    }
}
