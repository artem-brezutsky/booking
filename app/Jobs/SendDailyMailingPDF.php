<?php

namespace App\Jobs;

use App\Mail\DailyMailingPDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendDailyMailingPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pdfString;
    protected $userEmailArray;
    protected $studioName;
    protected $mailingDate;

    /**
     * Create a new job instance.
     *
     * @param $pdfString * PDF документ в виде строки
     * @param $userEmailArray * Массив с email пользователей подписанных на рассылку "комнаты"
     * @param $studioName * Название "комнаты"
     * @param $mailingDate * Дата рассылки
     */
    public function __construct(
        $pdfString,
        $userEmailArray,
        $studioName,
        $mailingDate
    ) {
        $this->pdfString = $pdfString;
        $this->userEmailArray = $userEmailArray;
        $this->studioName = $studioName;
        $this->mailingDate = $mailingDate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Mail::to($this->userEmailArray)->queue(
            new DailyMailingPDF(
                $this->pdfString,
                $this->studioName,
                $this->mailingDate
            ));
    }
}
