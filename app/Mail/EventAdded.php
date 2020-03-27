<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventAdded extends Mailable
{
    use Queueable, SerializesModels;

    protected $eventTitle;
    protected $eventAuthor;
    protected $eventDescription;
    protected $eventStudioTitle;

    /**
     * Create a new message instance.
     *
     * @param string $eventTitle
     * @param string $eventAuthor
     * @param string $eventDescription
     * @param string $eventStudioTitle
     */
    public function __construct(
        string $eventTitle,
        string $eventAuthor,
        string $eventDescription,
        string $eventStudioTitle
    ) {
        $this->eventTitle = $eventTitle;
        $this->eventAuthor = $eventAuthor;
        $this->eventDescription = $eventDescription;
        $this->eventStudioTitle = $eventStudioTitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->view('mail.add-event-mail')
            ->subject('Додана подія')
            ->with([
                'eventTitle'       => $this->eventTitle,
                'eventAuthor'      => $this->eventAuthor,
                'eventDescription' => $this->eventDescription,
                'eventStudioTitle' => $this->eventStudioTitle,
            ]);
    }
}
