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

    //Show event's form data
    public function formData(Event $event)
    {
        try {
            $data = Form::where('event_id', $event->id)->get();

            return response()->json([
                'data' => $data
            ], config('constants.HTTP_OK', 200));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching form.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'description' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'org_name' => 'max:255',
                'org_email' => 'max:255',
                'org_phone' => 'max:255',
                'org_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'category_id' => 'required',
                'limit' => 'integer',
                'location' => 'max:255',
                'plaform' => 'max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Handle image upload (if provided)
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('events/images', 'public'); // Store image in public disk
            }

            // Handle org logo upload (if provided)
            $orgLogoPath = null;
            if ($request->hasFile('org_logo')) {
                $orgLogoPath = $request->file('org_logo')->store('events/org_logos', 'public'); // Store logo in public disk
            }

            $event_create = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'org_name' => $request->org_name,
                'org_email' => $request->org_email,
                'org_phone' => $request->org_phone,
                'org_logo' => $orgLogoPath,
                'category_id' => $request->category_id,
                'limit' => $request->limit,
                'location' => $request->location,
                'plaform' => $request->plaform,
                'created_by' => Auth::id(),
            ]);

            return response()->json([
                'message' => 'Event created successfully',
                'data' => $event_create,
            ], config('constants.HTTP_OK', 200));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating event.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function search(Request $request){

        $title = $request->input('title');
        $category = $request->input('category');

        $events =  Event::latest()
            ->filter(request(['title','category']))
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'events' => $events,

        ], config('constants.HTTP_OK', 200));



    }
}
