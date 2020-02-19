<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;

class TopicController extends Controller
{
    public function get(Request $request)
    {
        $topics = Topic::orderBy('name', 'asc')->get();

        return response()->json($topics);
    }
}