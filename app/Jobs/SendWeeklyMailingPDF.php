<?php

namespace App\Jobs;

use App\Mail\WeeklyMailingPDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWeeklyMailingPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pdfString;
    protected $userEmailArray;
    protected $studioName;
    protected $mailingDates;

    /**
     * Create a new job instance.
     *
     * @param $pdfString
     * @param $userEmailArray
     * @param $studioName
     * @param $mailingDates
     */
    public function __construct(
        $pdfString,
        $userEmailArray,
        $studioName,
        $mailingDates
    ) {
        $this->pdfString = $pdfString;
        $this->userEmailArray = $userEmailArray;
        $this->studioName = $studioName;
        $this->mailingDates = $mailingDates;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->userEmailArray)->queue(
            new WeeklyMailingPDF(
                $this->pdfString,
                $this->studioName,
                $this->mailingDates
            ));
    }
}
