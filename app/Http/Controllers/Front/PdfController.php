<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Pdf\PdfGenerator;
use App\Studio;
use Illuminate\Http\Request;
use Mpdf\MpdfException;

class PdfController extends Controller
{
    public function index(Request $request, PdfGenerator $pdfGenerator)
    {
        $studio_id = $request->input('studioID');
        $startDate = $request->input('activeDateStart');
        $endDate = date('d-m-Y', strtotime('midnight', strtotime($request->input('activeDateEnd'))));
        $studio = Studio::find($studio_id);
        $studioTitle = $studio->getAttribute('name');
        $date = date('d-m-Y', strtotime('midnight', strtotime($startDate)));
        $calendarViewType = $request->input('calendarViewType');

        if ($calendarViewType === 'timeGridWeek') { // PDF from Week
            $weekTimes = [];

            for ($i = 0; $i < 7; $i++) {
                $currentTime = strtotime($startDate . ' + ' . $i . ' days');
                $currentDate = date('d.m.Y, H:i:s', $currentTime);
                $currentDay = date('Y-m-d', $currentTime);
                $weekTimes[$currentDay] = $pdfGenerator->buildTimesArray($studio_id, $currentDate);
            }

            try {
                $pdfGenerator->buildTableWeek($weekTimes, $studioTitle, $date, $endDate);

            } catch (MpdfException $e) {
                redirect()->back()->with('error', $e->getMessage());
            }

        } elseif ($calendarViewType === 'timeGridDay') { // PDF from Day
            $times = $pdfGenerator->buildTimesArray($studio_id, $startDate);
            try {
                $pdfGenerator->buildTableDay($date, $times, $studioTitle);
            } catch (MpdfException $e) {
                redirect()->back()->with('error', $e->getMessage());
            }
        }

        return abort(404);
    }
}
