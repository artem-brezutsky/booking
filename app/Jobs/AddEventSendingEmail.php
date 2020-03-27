<?php

namespace App\Jobs;

use App\Mail\EventAdded;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AddEventSendingEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userEmailList;
    protected $eventTitle;
    protected $eventAuthor;
    protected $eventDescription;
    protected $eventStudioTitle;

    /**
     * Create a new job instance.
     *
     * @param array $userEmailList * Массив с email пользователей подписанных на рассылку "комнаты"
     * @param string $eventTitle * Название события
     * @param string $eventAuthor * Автор события
     * @param string $eventDescription * Описаение события
     * @param string $eventStudioTitle * Название "комнаты" в которую добавили событие
     */
    public function __construct(
        array $userEmailList,
        string $eventTitle,
        string $eventAuthor,
        string $eventDescription,
        string $eventStudioTitle
    ) {
        $this->userEmailList = $userEmailList;
        $this->eventTitle = $eventTitle;
        $this->eventAuthor = $eventAuthor;
        $this->eventDescription = $eventDescription;
        $this->eventStudioTitle = $eventStudioTitle;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Mail::to($this->userEmailList)
            ->queue(new EventAdded(
                $this->eventTitle,
                $this->eventAuthor,
                $this->eventDescription,
                $this->eventStudioTitle
            ));
    }
}
