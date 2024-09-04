<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class HistoryController extends Controller
{
    public function searchhistory(User $user){

        try{
            // Retrieve a specific user

            $user = Auth::user();

            // Retrieve events associated with this user
            $events = $user->events;


            return response()->json([
                'message' => 'Success',
                'events' => $events
            ], 200);
        }catch(QueryException $e){
            return response()->json([
                'message' => 'Event Search Failed',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function myHistory(){
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve the events related to the current user through the pivot table 'histories'
            $events = $user->events;

            if ($events->isEmpty()) {
                return response()->json([
                    'message' => 'No data found',
                ]);
            }

            // Return the events, for example, as a JSON response
            return response()->json($events, 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'History Query Failed',
                'errors' => $e->getMessage()
            ]);
        }
    }
}
