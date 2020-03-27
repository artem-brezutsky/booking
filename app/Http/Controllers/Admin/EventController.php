<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Studio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\Factory;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Show admin events list
     *
     * @param Request $request
     * @return View|Factory
     */
    public function index(Request $request)
    {
        $studios = Studio::all(['name', 'id']);
        $studio_id = $request->get('choice-studio');

        if ($studio_id) {
            $studio_events = Studio::find($studio_id)->event;
        } else {
            $first = $studios->first()->id;
            $studio_events = Studio::find($first)->event;
        }

        // Дни недели в нормальном виде
        //TODO Вынести в модель?
        $days_of_week_arr = ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб',];
        foreach ($studio_events as $studio_event) {
            $collection_dow = trim($studio_event->days_of_week, '[]');

            //fixme переделать, приходит строка без пробелов
            $collection_dow = explode(',', $collection_dow);

            if ($studio_event->days_of_week != '[]') {
                foreach ($collection_dow as $key => $value) {
                    $collection_dow[$key] = $days_of_week_arr[$value];
                }
                $collection_dow = implode(', ', $collection_dow);
                $studio_event->days_of_week = $collection_dow;
            } else {
                $studio_event->days_of_week = '-';
            }

            // Если не повторяющееся событие то ставим "-"
            if (empty($studio_event->start_recur)) {
                $studio_event->start_recur = '-';
            }
            if (empty($studio_event->end_recur)) {
                $studio_event->end_recur = '-';
            }
        }

        return view('admin.pages.events.index', compact(['studio_events', 'studios', 'studio_id']));
    }

    /**
     * @param $eventID
     * @return array
     */
    public function destroy($eventID): array
    {
        $result = (new Event)->deleteEvent($eventID);
        if ($result) {
            return ['success' => true, 'message' => 'Событие удалено!'];
        }

        return ['success' => false];
    }
}
