<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FormController extends Controller
{
    public function index(Request $request, Event $event)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:13',
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validated->errors(),
                ], 422);
            }

            if ($event->limit !== null) {
                $currentFormsCount = Form::where('event_id', $event->id)->count();
                if ($currentFormsCount >= $event->limit) {
                    return response()->json([
                        'message' => 'Registration limit reached',
                        'errors' => ['limit' => 'The event has reached its registration limit.'],
                    ], 422);
                }
            }

            $formData = Form::create([
                'event_id' => $event->id,
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'dob' => $request->get('dob'),
            ]);

            return response()->json([
                'message' => 'Register Success',
                'data' => $formData,
            ]);
        } catch (\Exception $e){
            return response()->json([
                'message' => 'Register Failed',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
