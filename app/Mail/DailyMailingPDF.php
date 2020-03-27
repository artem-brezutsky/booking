<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyMailingPDF extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdf;
    protected $studioName;
    protected $mailingDate;

    /**
     * Create a new message instance.
     *
     * @param $pdf
     * @param $studioName
     * @param $mailingDate
     */
    public function __construct($pdf, $studioName, $mailingDate)
    {
        $this->pdf = $pdf;
        $this->studioName = $studioName;
        $this->mailingDate = $mailingDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        /**
         * name всегда должно быть с ".pdf"
         */
        $pdfName = $this->studioName . '_' . date('Y-m-d_H:i:s') . '.pdf';

        return $this->view('mail.daily-mailing')
            ->subject('Щоденна розсилка')
            ->with([
                'studioName'  => $this->studioName,
                'mailingDate' => $this->mailingDate,
            ])
            ->attachData(base64_decode($this->pdf), $pdfName, [
                'mime' => 'application/pdf',
            ]);
    }
}
