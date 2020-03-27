<?php

namespace App\Console\Commands;

use App\Jobs\SendWeeklyMailingPDF;
use App\Services\Pdf\PdfGenerator;
use App\Studio;
use App\User;
use DateTime;
use Illuminate\Console\Command;

class WeeklyMailing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly:mailing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail for users every week';

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
        \Log::info("Weekly:Mailing Cron is working fine!");
        $this->sendWeeklyPDF($pdfGenerator);
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */

        $this->info('Weekly:mailing Command Run successfully!');
    }

    /**
     * @param $pdfGenerator
     * @throws \Exception
     */
    protected function sendWeeklyPDF($pdfGenerator): void
    {
// Получаем все "комнаты"
        $studios = Studio::all();

        if ($studios->isNotEmpty()) {
            foreach ($studios as $studio) {
                // Пользователи которые подписаны на "комнату" в виде коллекции
                $userEmailList = (new User())->getMailingSubscribers($studio->id);

                if ($userEmailList->isNotEmpty()) {
                    $datetime = new DateTime('next monday'); // Понедельник
                    $nextMonday = $datetime->format('d-m-Y'); // Переводим в нормальный формат
                    $nextSunday = strtotime(date('d-m-Y', strtotime($nextMonday)) . ' +1 week'); // Воскресенье
                    $nextSunday = date('d-m-Y', $nextSunday); // Переводим в нормальный формат
                    $mailingDates = $nextMonday . '_' . $nextSunday; // Даты за которые осуществляется рассылка
                    $weekTimes = [];

                    for ($i = 0; $i < 7; $i++) {
                        $currentTime = strtotime($nextMonday . ' + ' . $i . ' days');
                        $currentDate = date('d.m.Y, H:i:s', $currentTime);
                        $currentDay = date('Y-m-d', $currentTime);
                        $weekTimes[$currentDay] = $pdfGenerator
                            ->buildTimesArray(
                                $studio->id,
                                $currentDate
                            );
                    }

                    $pdfString = $pdfGenerator
                        ->buildTableWeek(
                            $weekTimes,
                            $studio->name,
                            $nextMonday,
                            $nextSunday,
                            true
                        );

                    /**
                     * Выполение синхронно dispatchNow()
                     * $pdfString должна быть закодирована для передачи в Job
                     */
                    try {
                        SendWeeklyMailingPDF::dispatch(
                            base64_encode($pdfString),
                            $userEmailList->toArray(),
                            $studio->name,
                            $mailingDates);
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
