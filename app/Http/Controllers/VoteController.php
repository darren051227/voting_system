<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;

class VoteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        Vote::create($validated);

        return response()->json(['success' => true]);
    }

    public function getVotes()
    {
        $votes = Vote::all()->groupBy('subject')->map->avg('rating');
        return response()->json($votes);
    }
}