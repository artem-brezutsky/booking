<?php

namespace App\Console\Commands;

use App\Jobs\SendDailyMailingPDF;
use App\Services\Pdf\PdfGenerator;
use App\Studio;
use App\User;
use DateTime;
use Illuminate\Console\Command;

class DailyMailing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:mailing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail for users every day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param PdfGenerator $pdfGenerator
     * @return mixed
     * @throws \Exception
     */
    public function handle(PdfGenerator $pdfGenerator): void
    {
        \Log::info('Cron is working fine!');
        $this->sendDailyPDF($pdfGenerator);

        $this->info('Daily:Mailing Command Run successfully!');
    }

    /**
     * @param $pdfGenerator
     * @throws \Exception
     */
    protected function sendDailyPDF($pdfGenerator): void
    {
        // Получаем все "комнаты"
        $studios = Studio::all();

        if ($studios->isNotEmpty()) {
            foreach ($studios as $studio) {
                // Пользователи которые подписаны на "комнату" в виде коллекции
                $userEmailList = (new User())->getMailingSubscribers($studio->id);

                if ($userEmailList->isNotEmpty()) {
                    $datetime = new DateTime('tomorrow');
                    $tomorrow = $datetime->format('Y-m-d');

                    $times = $pdfGenerator->buildTimesArray($studio->id, $tomorrow);
                    $pdfString = $pdfGenerator->buildTableDay($tomorrow, $times, $studio->name, true);

                    /**
                     * Выполение синхронно dispatchNow()
                     * $pdfString должна быть закодирована для передачи в Job
                     */
                    try {
                        SendDailyMailingPDF::dispatch(
                            base64_encode($pdfString),
                            $userEmailList->toArray(),
                            $studio->name,
                            $tomorrow);
                    } catch (\Exception $exception) {
                        \Log::info($exception->getMessage());
                    }

                    if (config('mail.host', false) === 'smtp.mailtrap.io') {
//                        sleep(15);
                    }
                }
            }
        }
    }
}
