<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendTableAsMail extends Mailable
{
    use Queueable, SerializesModels;
    public $status;
    public $currentDate;
    public $url;
    public $oldStatus;
    /**
     * Create a new message instance.
     */
    public function __construct($status, $currentDate, $url, $oldStatus)
    {
        $this->status = $status;
        $this->currentDate = $currentDate;
        $this->url = $url;
        $this->oldStatus = $oldStatus;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('lagrosaedrian06@gmail.com', 'MediaOnePH'),
            subject: 'URL Status',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'MailDownSites',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}