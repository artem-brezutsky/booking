<?php

namespace App\Http\Controllers;

use App\Services\Pdf\PdfGenerator;

/**
 * Тестовый контроллер
 *
 */
class TestController extends Controller
{
    /**
     * Testing send mail
     */
    public function mailing()
    {
//        Mail::send('mail.index', [], function($message) {
//            $message->to('asdddddd-911132@inbox.mailtrap.io');
//            $message->subject('Testing');
//        });
    }

    public function testDailyMailing(PdfGenerator $pdfGenerator)
    {
//        $studios = Studio::all();
//
//        if ($studios->isNotEmpty()) {
//            foreach ($studios as $studio) {
//                // Пользователи которые подписаны на "комнату" в виде коллекции
//                $userEmailList = (new User())->getMailingSubscribers($studio->id);
//
//                if ($userEmailList->isNotEmpty()) {
//                    $datetime = new DateTime('next monday'); // Понедельник
//                    $nextMonday = $datetime->format('d-m-Y');
//                    $nextSunday = strtotime(date('d-m-Y', strtotime($nextMonday)) . ' +1 week');
//                    $nextSunday = date('d-m-Y', $nextSunday);
//                    $weekTimes = [];
//
//                    for ($i = 0; $i < 7; $i++) {
//                        $currentTime = strtotime($nextMonday . ' + ' . $i . ' days');
//                        $currentDate = date('d.m.Y, H:i:s', $currentTime);
//                        $currentDay = date('Y-m-d', $currentTime);
//                        $weekTimes[$currentDay] = $pdfGenerator->buildTimesArray($studio->id, $currentDate);
//                    }
//
//                    $pdfGenerator->buildTableWeek($weekTimes, $studio->name, $nextMonday, $nextSunday);
//
//                    /**
//                     * Выполение синхронно dispatchNow()
//                     * $pdfString должна быть закодирована для передачи в Job
//                     */
//                    try {
////                        SendDailyMailingPDF::dispatch(
////                            base64_encode($pdfString),
////                            $userEmailList->toArray(),
////                            $studio->name,
////                            $tomorrow);
//                    } catch (\Exception $exception) {
//                        \Log::info($exception->getMessage());
//                    }
//
//                    if (config('mail.host', false) === 'smtp.mailtrap.io') {
////                        sleep(15);
//                    }
//                }
//            }
//        }
//        dd(__METHOD__, "STAPE");
    }

    public function testCreateUser()
    {
//        $user = new User();
//        $user->name = 'test name';
//        $user->email = 'test@tesx.com';
//        $user->password = bcrypt('1234');
//
//        $user->save();
//        dd(__METHOD__);
    }
}
