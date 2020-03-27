<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * @property integer id
 * @property integer studio_id
 * @property string start_recur
 * @property mixed event_name
 * @property mixed author
 * @property integer author_id
 * @property string end_date
 * @property string start_date
 * @property string end_recur
 * @property false|string days_of_week
 * @property null|string description
 */
class Event extends Model
{
    protected $fillable = [
        'studio_id',
        'event_name',
        'start_date',
        'end_date',
        'start_recur',
        'end_recur',
        'all_day',
        'author',
        'author_id',
        'days_of_week',
        'description',
        'id',
    ];

    public function studio()
    {
        return $this->hasMany('App\Studio');
    }

    /**
     * Get All Events
     * @param string $from
     * @param string $to
     * @param integer $studio_id
     * @return array
     */
    public function allEvents($studio_id, $from = '', $to = ''): array
    {
        $get_events = $this->getEvents($studio_id, $from, $to);

        $event_list = [];

        foreach ($get_events as $key => $event) { //TODO

            $days = json_decode($event->days_of_week);
            $event_list[$key] = [
                'id'          => $event->id,
                'title'       => $event->event_name,
                'allDay'      => false,
                'author'      => $event->author, // return event author
                'author_id'   => $event->author_id, // return event author ID
                'description' => $event->description, // return event description
            ];

            if (!empty($days)) {
                $event_list[$key]['startTime'] = date('H:i:s', strtotime($event->start_date));
                $event_list[$key]['endTime'] = date('H:i:s', strtotime($event->end_date));
                $event_list[$key]['startRecur'] = date('Y-m-d', strtotime($event->start_date));
                $event_list[$key]['endRecur'] = date('Y-m-d', strtotime($event->end_recur) + 24 * 60 * 60);
                $event_list[$key]['daysOfWeek'] = $days;
            } else {
                $event_list[$key]['start'] = $event->start_date;
                $event_list[$key]['end'] = $event->end_date;
            }
        }

        return $event_list;
    }

    /**
     * Add Event
     * @param $request
     * @return bool
     */
    public function createEvent($request)
    {
        $event = new Event;

        $title = $request['title'];
        $start = $request['start'];
        $end = $request['end'];
        $endRecur = $request['end_recur_day'];
        $author = $request['author'];
        $authorID = $request['author_id'];
        $description = $request['description'];
        $daysOfWeek = $request['days_of_week'];
        $studioId = $request['studio_id']; // ИД "Комнаты"

        $where = '';

        if (!empty($daysOfWeek)) {

            $start_timestamp = strtotime($request['start']); // Дата начала события (timestamp)
            $end_timestamp = strtotime($request['end']); // Дата окончания события (timestamp)
            $start_recur_day = $start_timestamp;
            $end_recur_day = strtotime($request['end_recur_day']);

            $params['start_event'] = date('Y-m-d H:i:s', strtotime($start) + 1);
            $params['start_day'] = date('Y-m-d', $start_recur_day); // Дата начала события

            $params['end_day'] = date('Y-m-d', $end_recur_day); // Дата окончания события
            $params['end_day2'] = $params['end_day'];

            $params['start_time'] = date('H:i:s', $start_timestamp); // Время начала события
            $params['start_time2'] = $params['start_time'];
            $params['start_time3'] = $params['start_time'];
            $params['start_time4'] = $params['start_time'];
            $params['start_time5'] = $params['start_time'];
            $params['start_time6'] = $params['start_time'];
            $params['start_time7'] = $params['start_time'];
            $params['start_time8'] = $params['start_time'];

            $params['end_time'] = date('H:i:s', $end_timestamp); // Время окончания события
            $params['end_time2'] = $params['end_time'];
            $params['end_time3'] = $params['end_time'];
            $params['end_time4'] = $params['end_time'];
            $params['end_time5'] = $params['end_time'];
            $params['end_time6'] = $params['end_time'];
            $params['end_time7'] = $params['end_time'];
            $params['end_time8'] = $params['end_time'];

            $params['studio_id'] = $studioId; // ИД "Комнаты"

            $where .= 'WHERE :studio_id = `studio_id` AND ((';
            $mysql_days = [];
            $where .= '(';
            foreach ($daysOfWeek as $key => $day) { // Берём каждый выбраный день из массива
                $mysql_day = !$day ? 6 : ($day - 1);
                $params['day' . $key] = $day; // Добавляем в параментры запроса выбраные дни для повторений
                $mysql_days[] = $mysql_day;
                $where .= ' JSON_CONTAINS(days_of_week, :day' . $key . ", '$') > 0 OR"; // Поиск совпадений
            }
            $where = substr($where, 0, -2) . ")"; // -
            $week_days = implode(',', array_map('intval', $mysql_days));

            // Пересечение по датам
            $where .= ' AND (
                        (
                            DATE(:start_day) BETWEEN `start_recur` AND `end_recur`
                        ) OR (
                            DATE(:end_day) BETWEEN `start_recur` AND `end_recur`
                            )
                        )';
            // Пересечение по времени
            $where .= ' AND (
                                (
                                    TIME(:start_time) BETWEEN TIME(`start_date`) AND TIME(`end_date`)
                                ) OR (
                                    TIME(:end_time) BETWEEN TIME(`start_date`) AND TIME(`end_date`)
                                ) OR (
                                    TIME(`start_date`) BETWEEN TIME(:start_time5) AND TIME(:end_time5)
                                ) OR (
                                    TIME(`start_date`) BETWEEN TIME(:start_time6) AND TIME(:end_time6)
                                )
                            )
                        ';
            // Пересечение с началом либо концом соседних событий
            $where .= ' AND TIME(:start_time2) != TIME(`end_date`) AND TIME(:end_time2) != TIME(`start_date`)';
            $where .= ") OR (
                        (
                            `start_date` BETWEEN  CAST(:start_event as DATE) AND CAST(:end_day2 as DATE)
                        )
                            AND WEEKDAY(`start_date`) IN ($week_days) 
                            AND (
                                    (
                                        TIME(:start_time3) BETWEEN TIME(`start_date`) AND TIME(`end_date`)
                                    ) OR (
                                        TIME(:end_time3) BETWEEN TIME(`start_date`) AND TIME(`end_date`)
                                    ) OR(
                                        TIME(`start_date`) BETWEEN TIME(:start_time7) AND TIME(:end_time7)
                                    ) OR(
                                        TIME(`end_date`) BETWEEN TIME(:start_time8) AND TIME(:end_time8)
                                    )
                                )
                            AND TIME(:start_time4) != TIME(`end_date`) AND TIME(:end_time4) != TIME(`start_date`) AND `start_recur` IS NULL
                     )
                 )";

//            DB::enableQueryLog(); // Enable query log
            $query = DB::select('SELECT * FROM `events` ' . $where, $params);
//            dd(DB::getQueryLog());

//            $arr = DB::getQueryLog()[0];
//            $query = $arr['query'];
//            $keys = array_keys($arr['bindings']);
//            $values = array_values($arr['bindings']);
//
//            $keys = array_map(function ($value) {
//                return ':' . $value;
//            }, $keys);
//            $values = array_map(function ($value) {
//                if (is_numeric($value)) {
//                    return $value;
//                }
//
//                return '"' . $value . '"';
//            }, $values);
//
//            $arr = array_combine($keys, $values);
//
//            dd(strtr($query, $arr));

            if ($query) {
                return false;
            }
        }

        $event->event_name = $title; // Заголовок событий
        $event->start_date = Carbon::parse($start)->toDateTimeString(); // Дата и время начала события
        $event->end_date = Carbon::parse($end)->toDateTimeString(); // Дата и время окончания события
        $event->start_recur = !empty($daysOfWeek) ? Carbon::parse($start)->toDateTimeString() : null;
        $event->end_recur = !empty($daysOfWeek) ? Carbon::parse($endRecur)->toDateTimeString() : null;
        $event->author = $author; // Автор события
        $event->author_id = $authorID; // ID автора события
        $event->studio_id = $studioId; // ID "комнаты" в которую добавляют событие
        //fixme переделать
        $event->days_of_week = json_encode(isset($daysOfWeek) ? array_map('intval', $daysOfWeek) : []);
        $event->description = $description;
        // Сохраняем в БД событие
        $result = $event->save();
        return $result;

    }

    /**
     * @fixme делается проверка только по дню, без времени
     * @param $studio_id
     * @param $from
     * @param $to
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getEvents($studio_id, $from, $to)
    {
        return Event::query()
            ->where('studio_id', '=', $studio_id)
            ->where(static function (Builder $query) use ($from, $to) {
                return $query->whereBetween(
                    DB::raw('DATE(start_date)'),
                    [DB::raw("CAST('$from' as DATE)"), DB::raw("CAST('$to' as DATE)")]
                )->orWhere(static function (Builder $query) use ($from, $to) {
                    $query->whereBetween(
                        DB::raw("CAST('$from' as DATE)"),
                        [DB::raw('DATE(start_recur)'), DB::raw('DATE(end_recur)')]
                    )->orWhereBetween(
                        DB::raw("CAST('$to' as DATE)"),
                        [DB::raw('DATE(start_recur)'), DB::raw('DATE(end_recur)')]
                    );
                });
            })
            ->get();
    }

    /**
     * Delete Event Model Function
     * @param $id
     * @return int
     */
    public function deleteEvent($id)
    {
        $event = new Event;
        $result = $event->destroy($id);
        return $result;
    }

    /**
     * @param array $ids
     * @return int|boolean
     */
    public static function deleteStudioEvents(array $ids): int
    {
        $resultCount = self::destroy($ids);
        return $resultCount;
    }
}
