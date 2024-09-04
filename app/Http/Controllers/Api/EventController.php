<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        try {
            //fetch all avents
            $events = Event::paginate(10);

            //fetch lastest events
            $lastest_events = Event::orderBy('created_at', 'desc')->paginate(10);

            return response()->json([
                'events' => $events,
                'lastest_events' => $lastest_events,
            ], config('constants.HTTP_OK', 200)); // Default to 200 if the constant is not set
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json([
                'message' => 'An error occurred while fetching events.',
                'error' => $e->getMessage()
            ], config('constants.HTTP_INTERNAL_SERVER_ERROR', 500)); // Default to 500 if the constant is not set
        }
    }

    //Show Lastest Events
    public function lastestEvents()
    {
        try {
            $lastest_events = Event::orderBy('created_at', 'desc')->paginate(10);

            return response()->json([
                'lastest_events' => $lastest_events,
            ], config('constants.HTTP_OK', 200));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching events.',
                'error' => $e->getMessage()
            ], config('constants.HTTP_INTERNAL_SERVER_ERROR', 500));
        }
    }

    //Show Detail Event
    public function detail(int $id)
    {
        try {

            //fetch event detail data
            $event_detail = Event::findOrFail($id);

            return response()->json([
                'event' => $event_detail,
            ], config('constants.HTTP_OK', 200));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Not Found this event id',
                'error' => $e->getMessage()
            ], config('constants.HTTP_INTERNAL_SERVER_ERROR', 404));
        }
    }
}
