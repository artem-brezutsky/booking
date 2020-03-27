<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeeklyMailingPDF extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdf;
    protected $studioName;
    protected $mailingDates;

    /**
     * Create a new message instance.
     *
     * @param $pdf
     * @param $studioName
     * @param $mailingDates
     */
    public function __construct($pdf, $studioName, $mailingDates)
    {
        $this->pdf = $pdf;
        $this->studioName = $studioName;
        $this->mailingDates = $mailingDates;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /**
         * name всегда должно быть с ".pdf"
         */
        $pdfName = $this->studioName . '_' . date('Y-m-d_H:i:s') . '.pdf';

        return $this->view('mail.weekly-mailing')
            ->subject('Щотижнева розсилка')
            ->with([
                'studioName'   => $this->studioName,
                'mailingDates' => str_replace('_', ' - ', $this->mailingDates),
            ])
            ->attachData(base64_decode($this->pdf), $pdfName, [
                'mime' => 'application/pdf',
            ]);
    }
}
