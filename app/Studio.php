<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Studio
 * @package App
 *
 * @method Studio|null find(int $id)
 */
class Studio extends Model
{
    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    public function event()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Удаление всех событий определенной "комнаты"
     * @param int $studioID
     * @return int
     */
    public function deleteStudioEvents(int $studioID): int
    {
        $eventsCollection = Event::where('studio_id', '=', $studioID)->get(['id'])->toArray();

        if ($eventsCollection) {
            foreach ($eventsCollection as $eventValue) {
                $eventsIdArray[] = $eventValue['id'];
            }
        }

        if (!empty($eventsIdArray)) {
            return Event::deleteStudioEvents($eventsIdArray);
        }

        return 0;
    }
}
