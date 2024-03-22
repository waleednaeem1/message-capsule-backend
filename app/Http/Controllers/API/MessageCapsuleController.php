<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MessageCapsule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageCapsuleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'scheduled_opening_time' => 'date|after:now',
        ]);

        $user = Auth::user();

        $messageCapsule = new MessageCapsule();
        $messageCapsule->message = $request->input('message');
        $messageCapsule->scheduled_opening_time = $request->input('scheduled_opening_time');
        $messageCapsule->user_id = $user->id;
        $messageCapsule->save();

        return response()->json(['message' => 'Message capsule created successfully.'], 201);
    }

    public function getAllMessageCapsules(){
        $messageCapsule = MessageCapsule::with('user')->get();
        return response()->json(['messageCapsule' => $messageCapsule], 200);
    }

    public function getUnopenedMessageCapsules()
    {
        $unopenedCapsules = MessageCapsule::with('user')->where('opened', false)->get();
        return response()->json(['messageCapsule' => $unopenedCapsules], 200);
    }

    // public function update(Request $request, MessageCapsule $messageCapsule)
    // {
    //     $request->validate([
    //         'message' => 'required',
    //         'scheduled_opening_time' => 'date|after:now',
    //     ]);

    //     $user = Auth::user();
      
    //     if ($user->id != $request->user_id) {
    //         return response()->json(['message' => 'Not authroized to edit this message capsule'], 401);
    //     } 

    //     if (Carbon::now() <= $messageCapsule->scheduled_opening_time) {
    //         return response()->json(['message' => 'Message Scheduled Opening Time has not passed yet'], 401);
    //     }

    //     $messageCapsule->message = $request->input('message');
    //     $messageCapsule->scheduled_opening_time = $request->input('scheduled_opening_time');
    //     $messageCapsule->user_id = $request->input('user_id');
    //     $messageCapsule->save();

    //     return response()->json(['message' => 'Message capsule updated successfully.'], 200);
    // }

    public function update(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'scheduled_opening_time' => 'date|after:now',
        ]);

        $user = Auth::user();
      
        
        $id = $request->route('id');
        $messageCapsule = MessageCapsule::find($id);

        if ($user->id != $messageCapsule->user_id) {
            return response()->json(['message' => 'Not authroized to edit this message capsule'], 401);
        } 


        if($messageCapsule){
            if (Carbon::now() <= $messageCapsule->scheduled_opening_time) {
                return response()->json(['message' => 'Message Scheduled Opening Time has not passed yet'], 401);
            }

            $messageCapsule->message = $request->input('message');
            $messageCapsule->scheduled_opening_time = $request->input('scheduled_opening_time');
            $messageCapsule->user_id = $request->input('user_id');
            $messageCapsule->save();

            return response()->json(['message' => 'Message capsule updated successfully.'], 200);
        }else{
            return response()->json(['message' => 'Message not found'], 404);
        }
       
    }

    public function show(Request $request)
    {
        $messageCapsuleId = $request->route('id');
        return MessageCapsule::find($messageCapsuleId)->toJson();
    }
}
