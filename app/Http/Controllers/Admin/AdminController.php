<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return View|Factory
     */
    public function index()
    {
        return view('admin.pages.index');
    }

//    /**
//     * Show all events with choice "room"
//     * @param Request $request
//     * @return View|Factory
//     */
//    public function showEvents(Request $request)
//    {
//        $studios = Studio::all(['name', 'id']);
//        $studio_id = $request->get('choice-studio');
//
//        if ($studio_id) {
//            $studio_events = Studio::find($studio_id)->event;
//        } else {
//            $first = $studios->first()->id;
//            $studio_events = Studio::find($first)->event;
//        }
//
//        // Дни недели в нормальном виде
//        //TODO Вынести в модель?
//        $days_of_week_arr = ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб',];
//        foreach ($studio_events as $studio_event) {
//            $collection_dow = trim($studio_event->days_of_week, '[]');
//            $collection_dow = explode(', ', $collection_dow);
//
//            if ($studio_event->days_of_week != '[]') {
//                foreach ($collection_dow as $key => $value) {
//                    $collection_dow[$key] = $days_of_week_arr[$value];
//                }
//                $collection_dow = implode(', ', $collection_dow);
//                $studio_event->days_of_week = $collection_dow;
//            } else {
//                $studio_event->days_of_week = '-';
//            }
//
//            // Если не повторяющееся событие то ставим "-"
//            if (empty($studio_event->start_recur)) {
//                $studio_event->start_recur = '-';
//            }
//            if (empty($studio_event->end_recur)) {
//                $studio_event->end_recur = '-';
//            }
//        }
//
//        return view('admin.pages.events.index', [
//            'studio_events' => $studio_events,
//            'studios'       => $studios,
//            'studio_id'     => $studio_id,
//        ]);
//    }
}
