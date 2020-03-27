<?php

namespace App\Services\Pdf;

use App\Event;
use Illuminate\Support\Str;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Mpdf\Output\Destination;

class PdfGenerator
{
    /**
     * @fixme если у события конечная время 00:00 оно не добавляется в выборку
     * @param int $studioId
     * @param string $date
     * @return array
     */
    public function buildTimesArray(int $studioId, string $date): array
    {
        $startTimestamp = strtotime('midnight', strtotime($date));
        $endTimestamp = (int)($startTimestamp + (23.75 * 60 * 60));

        $startDate = date('Y-m-d H:i:s', $startTimestamp);
        $endDate = date('Y-m-d H:i:s', ($endTimestamp + 14 * 60));

        $dayNumber = (int)date('N', $startTimestamp);
        $dayNumber = $dayNumber === 7 ? 0 : $dayNumber;

        $times = [];

        for ($currentTime = $startTimestamp; $currentTime <= $endTimestamp; $currentTime += 15 * 60) {
            $currentDate = date('H:i:s', $currentTime);
            $times[$currentDate] = null;
        }

        $events = (new Event())->getEvents($studioId, $startDate, $endDate)->all();
        $events = array_filter($events, static function (Event $event) use ($dayNumber) {
            return !$event->getAttribute('start_recur') || in_array($dayNumber,
                    json_decode($event->getAttribute('days_of_week'), true), true);
        });

        usort($events, static function (Event $event1, Event $event2) {
            $startTime1 = date('H:i:s', strtotime($event1->getAttribute('start_date')));
            $startTime2 = date('H:i:s', strtotime($event2->getAttribute('start_date')));
            return $startTime1 <=> $startTime2;
        });

        /** @var Event $event */
        $event = reset($events);
        if (!$event) {
            return $times;
        }

        $eventStartTime = date('H:i:s', strtotime($event->getAttribute('start_date')));
        $eventEndTime = date('H:i:s', strtotime($event->getAttribute('end_date')));

        foreach ($times as $time => $value) {
            if ($eventStartTime > $time) {
                continue;
            }

            // @fixme из-за метода getEvents() модели Event не выводит событие если оно заканчиватся в 00:00
            if ($eventEndTime === '00:00:00') {
                $eventEndTime = '23:59:00';
            }

            if ($eventEndTime <= $time) {
                $event = next($events);

                if (!$event) {
                    break;
                }

                $eventStartTime = date('H:i:s', strtotime($event->getAttribute('start_date')));
                $eventEndTime = date('H:i:s', strtotime($event->getAttribute('end_date')));
            }

            if ($time >= $eventStartTime) {
                $times[$time] = $event;
            }
        }

        return $times;
    }


    /**
     * @param string $date
     * @param array $times
     * @param string $studioTitle
     * @param bool $mailing
     * @return string|null
     * @throws MpdfException
     */
    public function buildTableDay(string $date, array $times, string $studioTitle, $mailing = false): ?string
    {

        /** @var Event|null $currentEvent */
        $currentEvent = null;
        $table = '';
        $table .= '<table autosize="1" border="0" cellpadding="1" cellspacing="0" align="center" width="100%" style="border-collapse: collapse;font-size: 5.25pt;">';
        foreach ($times as $time => $event) {

            if (!$event) {
                $currentEvent = null;
                $table .= "<tr><td align='center' width='60px'>{$time}</td><td></td></tr>";
                continue;
            }

            if ($currentEvent === $event) {
                $table .= "<tr style='background-color: #f3f3f3;'><td align='center'>{$time}</td><td style='border: none;'></td></tr>";
                continue;
            }

            $table .= "<tr  style='background-color: #ddd;'><td align='center'>{$time}</td><td style='border-bottom: none;'>{$event->getAttribute('event_name')}</td></tr>";
            $currentEvent = $event;
        }
        $table .= '</table>';

        $mpdf = new Mpdf();
        $mpdf->SetHeader($studioTitle . ' ' . $date);
        $mpdf->WriteHTML($table);

        if ($mailing) {
            return $mpdf->Output(Str::slug($studioTitle) . '_' . $date . '.pdf', Destination::STRING_RETURN);
        }

        $mpdf->Output(//            Str::slug($studioTitle) . '_' . $date . '.pdf',
//            Destination::DOWNLOAD
        );
    }

    /**
     * Build the table with view "Week"
     * @fixme сделать что то с бордерами, слишком толстые
     * @fixme Undefined index 03:00:00
     * @param array $days
     * @param string $studioTitle
     * @param string $startDate
     * @param string $endDate
     * @param bool $mailing
     * @return string|null
     * @throws MpdfException
     */
    public function buildTableWeek(
        array $days,
        string $studioTitle,
        string $startDate,
        string $endDate,
        $mailing = false
    ): ?string {
        $firstDay = reset($days);
        $times = array_keys($firstDay);

        $table = '';
        $table .= '<table autosize="1" border="1" cellpadding="1" cellspacing="0" align="center" width="100%" style="border-collapse: collapse;font-size: 4.5pt;">';
        $table .= '<thead><tr><th align="center" width="60px">Время</th>';

        foreach ($days as $day => $events) {
            $table .= '<th>' . $day . '</th>';
        }

        $table .= '</tr></thead><tbody>';
        $lastTime = '';

        foreach ($times as $time) {
            $table .= '<tr>';
            $table .= '<td align="center">' . $time . '</td>';

            /** @var Event[] $day */
            foreach ($days as $day) {
                $event = $day[$time];
                $prevEvent = $day[$lastTime] ?? null;

                if (!$event) {
                    $table .= "<td align='center'></td>";
                    continue;
                }

                if ($prevEvent === $event) {
                    $table .= "<td style='background-color: #f3f3f3; border-top: none; border-bottom: none; border-left: 0.5px solid inherit'></td>";
                    continue;
                }

                $table .= "<td style='background-color: #ddd; border-left: 0.5px solid inherit; border-bottom: none'>{$event->getAttribute('event_name')}</td>";
            }

            $table .= '</tr>';
            $lastTime = $time;
        }

        $table .= '</tbody></table>';

        $mpdf = new Mpdf();
        $mpdf->SetHeader($studioTitle . ' (' . $startDate . ' ' . $endDate . ')');
        $mpdf->WriteHTML($table);

        if ($mailing) {
            return $mpdf->Output(Str::slug($studioTitle) . '_' . $startDate . '_' . $endDate . '.pdf',
                Destination::STRING_RETURN);
        }

        $mpdf->Output(//            Str::slug($studioTitle) . '_' . $startDate . '_' . $endDate . '.pdf',
//            Destination::DOWNLOAD
        );
    }
}