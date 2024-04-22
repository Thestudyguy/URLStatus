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
    public $URLstatus;
    public $currentDate;
    /**
     * Create a new message instance.
     */
    public function __construct($URLstatus, $currentDate)
    {
        $this->URLstatus = $URLstatus;
        $this->currentDate = $currentDate;
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