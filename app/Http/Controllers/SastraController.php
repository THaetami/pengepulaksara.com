<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Sastra;
use App\Models\User;
use App\Models\Like;

class SastraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['search', 'index', 'getSastrasByUser', 'getSastraBySlug']]);
    }

    public function index()
    {
        $sastras = Sastra::latest()
            ->where('is_delete', false)
            ->with(['comment' => function ($query) {
                $query->where('is_delete', false);
            }])
            ->take(10)
            ->get();

        return response()->json([
            "status" => "succes",
            "data" => [
                "sastras" => $sastras
            ]
        ]);
    }

    public function getSastras()
    {
        $sastras = Sastra::latest()
            ->where('is_delete', false)
            ->with(['comment' => function ($query) {
                $query->where('is_delete', false);
            }])
            ->paginate(10);

        return response()->json([
            "status" => "succes",
            "sastras" => $sastras
        ]);
    }

    public function getSastrasByUser(Request $request)
    {
        $penulis = $request->username;

        $user = User::where('username', $penulis)->first();
        if (!$user) {
            return response()->json([
                "status" => "fail",
                "message" => "user tidak ditemukan"
            ], 404);
        }

        $sastras = Sastra::latest()
            ->where('penulis', $penulis)
            ->where('is_delete', false)
            ->with(['comment' => function ($query) {
                $query->where('is_delete', false);
            }])
            ->paginate(10);

        return response()->json([
            "status" => "succes",
            "data" => [
                "user" => $user,
                "sastras" => $sastras,
                "count" => $sastras->total()
            ]
        ]);
    }

    public function getSastrasByLikeUser(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return response()->json([
                "status" => "fail",
                "message" => "user tidak ditemukan"
            ], 404);
        }

        $id = User::where('username', $request->username)->pluck('id');
        $love = Like::where('author_id', $id)->pluck('sastra_id');
        $sastras =  Sastra::whereIn('id', $love);
        $sastras = Sastra::select(['sastras.*'])
            ->join('likes', 'sastras.id', '=', 'likes.sastra_id')
            ->where('is_delete', false)
            ->where('likes.author_id', $id)
            ->whereIn('sastras.id', $love)
            ->orderBy('likes.created_at', 'DESC')
            ->paginate(10);

        return response()->json([
            "status" => "success",
            'data' => [
                "user" => $user,
                "sastras" => $sastras,
                "count" => $sastras->total()
            ],
        ]);
    }

    public function getSastraBySlug(Request $request)
    {
        $sastras = Sastra::where('slug', $request->slug)
            ->where('is_delete', false)
            ->with(['comment' => function ($query) {
                $query->where('is_delete', false);
            }])
            ->latest()->get();

        if ($sastras->isEmpty()) {
            return response()->json([
                "status" => "fail",
                "message" => "sastra tidak ditemukan"
            ], 404);
        }

        return response()->json([
            "status" => "succes",
            "data" => [
                "sastras" => $sastras
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:30',
            'body' => 'required'
        ], [
            'title.required' => 'judul tidak boleh kosong',
            'title.max' => 'judul maksimal 30 karakter',
            'body.required' => 'body tidak boleh kosong',
        ]);

        $validatedData['author_id'] = auth()->user()->id;
        $validatedData['penulis'] = auth()->user()->username;
        $validatedData['slug'] = Str::uuid();

        $sastra = Sastra::create($validatedData);

        if ($sastra) {
            return response()->json([
                "status" => "success",
                "message" => "Sastra berhasil ditambahkan",
                "data" => [
                    "addedSastra" => [
                        "title" => $sastra->title,
                        "body" => $sastra->body,
                        "penulis" => $sastra->penulis,
                        "slug" => $sastra->slug
                    ]
                ]
            ], 201);
        } else {
            return response()->json([
                "status" => "fail",
                "message" => "Sastra gagal ditambahkan"
            ], 400);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $user = auth()->user();
        $sastra = Sastra::where('id', $id)->first();

        if (!$sastra) {
            return response()->json([
                "status" => "fail",
                "message" => "Sastra tidak ditemukan!!"
            ], 404);
        }

        if ($sastra->author_id !== $user->id) {
            return response()->json([
                "status" => "fail",
                "message" => "Anda tidak berhak mengakses resource ini!!"
            ], 403);
        }

        $sastra->is_delete = true;
        $sastra->save();

        return response()->json([
            "status" => "success",
        ], 204);
    }
}
