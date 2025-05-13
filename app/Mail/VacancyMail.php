<?php

namespace App\Mail;

use App\Models\Vacancy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VacancyMail extends Mailable
{
    use Queueable, SerializesModels;

	private array $data;
	private $attachment;
	private $vacancy;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $attachment = null)
    {
        $this->data         = $data;
		$this->attachment   = $attachment;
	    $this->vacancy      = Vacancy::find($this->data['vacancy_id']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Equi-par: Postulación para '.$this->vacancy->title
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
	    return new Content(
		    view: 'mail.vacancy',
		    with: [
				'title'     => $this->vacancy->title,
				'data'      => $this->data
		    ]
	    );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
	        Attachment::fromPath($this->attachment->getRealPath())
		        ->as($this->attachment->getClientOriginalName())
		        ->withMime($this->attachment->getClientMimeType()),
        ];
    }
}
