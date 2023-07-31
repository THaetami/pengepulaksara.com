<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponseHelper;
use App\Http\Requests\CommentStoreRequest;
use Illuminate\Http\Request;

use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(CommentStoreRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['author_id'] = auth()->user()->id;

        $comment = Comment::create($validatedData);

        if ($comment) {
            return JsonResponseHelper::respondSuccess([
                "addedComment" => [
                    "commentar" => $comment->commentar
                ]
            ], 201);
        } else {
            return JsonResponseHelper::respondFail("comment gagal ditambahkan");
        }
    }

    public function delete(Request $request)
    {
        $comment = Comment::where('id', $request->id)
            ->where('is_delete', false)
            ->first();

        if (!$comment) {
            return JsonResponseHelper::respondErrorNotFound("comoment tidak ditemukan");
        }

        if ($comment->author_id !== auth()->user()->id) {
            return JsonResponseHelper::respondErrorForbidden("Anda tidak berhak mengakses resource ini");
        }

        $comment->update(['is_delete' => true]);

        return JsonResponseHelper::respondSuccess([], 204);
    }
}
