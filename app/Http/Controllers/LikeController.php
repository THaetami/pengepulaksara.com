<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Sastra;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $author_id = auth()->user()->id;
        $sastra_id = $request->sastra_id;

        $sastra = Sastra::where('id', $request->sastra_id)
            ->where('is_delete', false)
            ->first();

        if (!$sastra) {
            return response()->json([
                "status" => "fail",
                "message" => "sastra tidak ditemukan"
            ], 400);
        }

        $like = Like::where('author_id', $author_id)
            ->where('sastra_id', $sastra_id)
            ->first();

        if ($like === null) {
            $like = Like::create([
                'author_id' => $author_id,
                'sastra_id' => $sastra_id
            ]);
            $response_message = "like";
        } else {
            $like->delete();
            $response_message = "unlike";
        }

        $count = Like::where('sastra_id', $sastra_id)->count();

        return response()->json([
            "status" => "succes",
            "message" => $response_message,
            "count" => $count,
        ]);
    }
}
