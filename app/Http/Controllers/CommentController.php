<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Sastra;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'commentar' => 'required'
        ], [
            'commentar.required' => 'komentar tidak boleh kosong'
        ]);

        $validatedData['author_id'] = auth()->user()->id;

        $sastra = Sastra::where('id', $request->sastra_id)
            ->where('is_delete', false)
            ->first();

        if ($sastra) {
            $validatedData['sastra_id'] = $request->sastra_id;
        } else {
            return response()->json([
                "status" => "fail",
                "message" => "sastra tidak ditemukan"
            ], 404);
        }

        $comment = Comment::create($validatedData);

        if ($comment) {
            return response()->json([
                "status" => "success",
                "message" => "comment berhasil ditambahkan",
                "data" => [
                    "addedComment" => [
                        "commentar" => $comment->commentar
                    ]
                ]
            ], 201);
        } else {
            return response()->json([
                "status" => "fail",
                "message" => "comment gagal ditambahkan"
            ]);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $user = auth()->user()->id;
        $comment = Comment::where('id', $id)
            ->where('is_delete', false)
            ->first();

        if (!$comment) {
            return response()->json([
                "status" => "fail",
                "message" => "comment tidak ditemukan"
            ], 404);
        }

        if ($comment->author_id !== $user) {
            return response()->json([
                "status" => "fail",
                "message" => "anda tidak berhak mengakses resource ini!!"
            ], 403);
        }

        $comment->is_delete = true;
        $comment->save();

        return response()->json([
            "status" => "success"
        ]);
    }
}
