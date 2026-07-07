<?php
// app/Mail/NewLeadNotification.php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewLeadNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Lead $lead;

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Новая заявка на сайте Инь Ян',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.leads.new',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
