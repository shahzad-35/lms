<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\WatchLog;


Route::middleware('auth:sanctum')->post('/watch-log', function (Request $request) {
    $data = $request->validate([
        'user_id' => 'required|exists:users,id',
        'lesson_id' => 'required|exists:lessons,id',
        'current_time' => 'required|numeric',
        'duration' => 'required|numeric',
        'event' => 'required|string'
    ]);


    $log = WatchLog::updateOrCreate(
        [
            'user_id' => $data['user_id'],
            'lesson_id' => $data['lesson_id']
        ],
        [
            'watched_seconds' => $data['current_time'],
            'last_position' => $data['current_time'],
            'completed' => $data['event'] === 'ended'
        ]
    );


    return response()->json(['status' => 'ok', 'log' => $log]);
});
