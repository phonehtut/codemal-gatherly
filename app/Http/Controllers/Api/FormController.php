<?php

namespace App\Http\Controllers\Api;

use App\Models\Form;
use App\Models\Event;
use App\Models\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class FormController extends Controller
{
    public function index(Request $request, Event $event)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('forms')->where(function ($query) use ($event) {
                        return $query->where('event_id', $event->id);
                    }),
                ],
                'phone' => [
                    'required',
                    'string',
                    'max:13',
                    Rule::unique('forms')->where(function ($query) use ($event) {
                        return $query->where('event_id', $event->id);
                    }),
                ],
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validated->errors(),
                ], 422);
            }

            if ($event->limit !== 0) {
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
                'user_id' => Auth::id(),
                'dob' => $request->get('dob'),
            ]);

            // Create history in histories table
            History::create([
                'event_id' => $event->id,
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'message' => 'Register Success',
                'data' => $formData
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Register Failed',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
