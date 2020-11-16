<?php

namespace App\Mail;

use App\Http\Resources\AttachmentResource;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Contact
     */
    protected $contact;

    /**
     * ContactMail constructor.
     * @param Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('email@email.com', 'NetShow.me')->to(env('MAIL_TO'))->view('emails.contact')->subject('Novo contato criado')->with([
            'id' => $this->contact->id,
            'name' => $this->contact->name,
            'email' => $this->contact->email,
            'phone' => $this->contact->phone,
            'message_sent' => $this->contact->message,
            'attachment' => new AttachmentResource($this->contact->attachment),
            'ip' => $this->contact->ip,
            'created_at' => $this->contact->created_at->format('d-m-Y H:i:s'),
        ]);
    }
}
