<?php

namespace App\Http\Controllers\Front;

use App\Event;
use App\Http\Controllers\Controller;
use App\Jobs\AddEventSendingEmail;
use App\Studio;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Отображение событий
     * @param Request $request
     * @return View|Factory
     */
    public function index(Request $request)
    {
        $slug = $request->route('studio');
        $studio = Studio::where('slug', '=', $slug)->firstOrFail();
        $user = auth()->user();
        $user->hasPermission('STUDIO_ID_' . $studio->id);
        $studio_id = $studio->id;
        $studioName = $studio->name;

        if ($user->hasPermission('STUDIO_ID_' . $studio->id)) {
            return view('front.pages.events.index', compact('studio_id', 'studioName'));
        }

        return abort(404);
    }

    /**
     * AJAX Загрузка событий
     * @param Request $request
     * @return array
     */
    public function load(Request $request): array
    {
        $from = date('Y-m-d H:i:s', strtotime($request->get('start')));
        $to = date('Y-m-d H:i:s', strtotime($request->get('end')));

        $events = new Event();

        $studio_id = $request->get('studio_id');

        return $events->allEvents($studio_id, $from, $to);
    }

    /**
     * Create a new event
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $event = new Event;
        $result = $event->createEvent($request);
        if ($result) {
            if ($request->get('send_mail') === 'true') {
                $studioID = $request->get('studio_id');
                $userEmailList = (new User())->getMailingSubscribers($studioID);

                if ($userEmailList->isNotEmpty()) {

                    $eventTitle = $request->get('title');
                    $eventAuthor = $request->get('author');

                    if ($request->get('description')) {
                        $eventDescription = $request->get('description');
                    } else {
                        $eventDescription = '';
                    }

                    $eventStudioTitle = Studio::select('name')->findOrFail($studioID)->name;

                    // Делаем из коллекции массив
                    $userEmailList = $userEmailList->all();

                    AddEventSendingEmail::dispatch(
                        $userEmailList,
                        $eventTitle,
                        $eventAuthor,
                        $eventDescription,
                        $eventStudioTitle
                    );
                }
            }

            return response()->json(['status' => true, 'message' => 'Событие добавлено!']);
        }

        return response()->json(['status' => false, 'message' => 'Время занято!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request): array
    {
        $id = $request->id;
        $result = (new Event)->deleteEvent($id);
        if ($result) {
            return ['success' => true, 'message' => 'Событие удалено!'];
        }

        return ['success' => false];
    }
}
