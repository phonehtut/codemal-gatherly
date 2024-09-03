<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, Event $event)
    {

        $rating = $request->rating;

        
     
   
        if ($rating < 1 || $rating > 5) {
            return response()->json(['error' => 'Invalid rating value.'], 500);
        }

        $user = Auth::user();
        

        $existingRating = $event->ratings()->where('user_id', $user->id ?? null)->first();

        if ($existingRating) {

            $existingRating->update([
                'rating' => $rating
                
            ]);

            $ratingpoint = $event->ratings()->avg('rating');
            $event->update(['rating' => $ratingpoint]);

            return response()->json(['message' => 'Rating updated successfully.']);

        } else {
            $ratings = new Rating(['rating' => $rating,'event_id' => $event->id,'user_id' => $user->id]);
            
          
            if ($user) {
            

                $user->userratings()->save($ratings);
            }
            
           
            

            
            
        }

        $ratingpoint = $event->ratings()->avg('rating');
        $event->update(['rating' => $ratingpoint]);

      
        return response()->json(['message' => 'Rating saved successfully.']);
    }
}
