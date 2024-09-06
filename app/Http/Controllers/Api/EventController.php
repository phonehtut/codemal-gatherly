<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    // Show All Event and Latest Event
    public function index()
    {
        try {
            //fetch all avents
            $events = Event::paginate(10);

            //fetch latest events
            $latest_events = Event::orderBy('created_at', 'desc')->paginate(10);

            return response()->json([
                'events' => $events,
                'latest_events' => $latest_events,
            ], config('constants.HTTP_OK', 200)); // Default to 200 if the constant is not set
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json([
                'message' => 'An error occurred while fetching events.',
                'error' => $e->getMessage()
            ], config('constants.HTTP_INTERNAL_SERVER_ERROR', 500)); // Default to 500 if the constant is not set
        }
    }

    //Show Latest Events
    public function latestEvents()
    {
        try {
            $latest_events = Event::orderBy('created_at', 'desc')->paginate(10);

            return response()->json([
                'latest_events' => $latest_events,
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
            // Check if the current user is the creator of the event
            if ($event->created_by !== Auth::id()) {
                return response()->json([
                    'message' => 'Unauthorized to access this form data.'
                ], 403); // HTTP 403 Forbidden
            }

            // Fetch form data related to the event
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

    // Create Event
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
            ], config('constants.HTTP_OK', 201));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating event.',
                'error' => $e->getMessage()
            ]);
        }
    }

    // Update My Event Data
    public function update(Request $request, Event $event)
    {
        try {
            // Check if the event belongs to the current user
            if ($event->created_by !== Auth::id()) {
                return response()->json([
                    'message' => 'You are not authorized to update this event.',
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'title' => 'nullable|max:255',
                'description' => 'nullable',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'org_name' => 'nullable|max:255',
                'org_email' => 'nullable|max:255',
                'org_phone' => 'nullable|max:255',
                'org_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'category_id' => 'nullable',
                'limit' => 'nullable|integer',
                'location' => 'nullable|max:255',
                'plaform' => 'nullable|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Handle image upload (if provided)
            $imagePath = $event->image;
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $request->file('image')->store('events/images', 'public'); // Store image in public disk
            }

            // Handle org logo upload (if provided)
            $orgLogoPath = $event->org_logo;
            if ($request->hasFile('org_logo')) {
                // Delete the old logo if it exists
                if ($orgLogoPath && Storage::disk('public')->exists($orgLogoPath)) {
                    Storage::disk('public')->delete($orgLogoPath);
                }
                $orgLogoPath = $request->file('org_logo')->store('events/org_logos', 'public'); // Store logo in public disk
            }

            // Update event
            $event->update([
                'title' => $request->title ?? $event->title,
                'description' => $request->description ?? $event->description,
                'image' => $imagePath,
                'start_date' => $request->start_date ?? $event->start_date,
                'end_date' => $request->end_date ?? $event->end_date,
                'org_name' => $request->org_name ?? $event->org_name,
                'org_email' => $request->org_email ?? $event->org_email,
                'org_phone' => $request->org_phone ?? $event->org_phone,
                'org_logo' => $orgLogoPath,
                'category_id' => $request->category_id ?? $event->category_id,
                'limit' => $request->limit ?? $event->limit,
                'location' => $request->location ?? $event->location,
                'plaform' => $request->plaform ?? $event->plaform,
            ]);

            return response()->json([
                'message' => 'Event updated successfully',
                'data' => $event,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the event.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Show my events list
    public function myEvents()
    {
        $user = Auth::user();

        // Retrieve events where the current user is the creator
        $events = Event::where('created_by', $user->id)->get();

        if ($events->isEmpty()) {
            return response()->json([
                'message' => 'No events available.',
            ], 404);
        }

        return response()->json([
            'events' => $events,
        ], config('constants.HTTP_OK', 200));
    }

    // Delete my event
    // Delete my event
    public function destroy($id)
    {
        // Attempt to find the event by ID
        $event = Event::find($id);

        // Check if the event exists
        if (is_null($event)) {
            return response()->json([
                'message' => 'Event not found.',
            ], 404);
        }

        // Check if the authenticated user is the creator of the event
        if ($event->created_by !== Auth::id()) {
            return response()->json([
                'message' => 'You do not have permission to delete this event.',
            ], 403);
        }

        // Attempt to delete the event
        try {
            $event->delete();

            return response()->json([
                'message' => 'Event deleted successfully.',
                'data' => $event,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the event.',
                'error' => $e->getMessage(),
            ], 500);
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
