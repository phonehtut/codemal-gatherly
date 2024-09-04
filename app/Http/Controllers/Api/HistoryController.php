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
            ], 500);
        }catch(QueryException $e){
            return response()->json([
                'message' => 'Event Search Failed',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
