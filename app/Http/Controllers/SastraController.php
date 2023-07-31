<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponseHelper;
use App\Http\Requests\SastraStoreRequest;
use Illuminate\Http\Request;
use App\Models\Sastra;
use App\Models\User;

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

        return JsonResponseHelper::respondSuccess([
            "sastras" => $sastras,
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

        return JsonResponseHelper::respondSuccess([
            "sastras" => $sastras,
        ]);
    }

    public function getSastrasByUser(Request $request)
    {
        $penulis = $request->username;

        $user = User::where('username', $penulis)->first();
        if (!$user) {
            return JsonResponseHelper::respondErrorNotFound("user tidak ditemukan");
        }

        $sastras = Sastra::latest()
            ->where('penulis', $penulis)
            ->where('is_delete', false)
            ->with(['comment' => function ($query) {
                $query->where('is_delete', false);
            }])
            ->paginate(10);

        return JsonResponseHelper::respondSuccess([
            "user" => $user,
            "sastras" => $sastras,
            "count" => $sastras->total()
        ]);
    }

    public function getSastrasByLikeUser(Request $request)
    {
        $user = $this->getUserByUsername($request->username);
        if (!$user) {
            return JsonResponseHelper::respondErrorNotFound("user tidak ditemukan");
        }

        $sastras = $this->getSastrasLikedByUser($user->id);

        return JsonResponseHelper::respondSuccess([
            "user" => $user,
            "sastras" => $sastras,
            "count" => $sastras->total()
        ]);
    }

    private function getUserByUsername($username)
    {
        return User::where('username', $username)->first();
    }

    private function getSastrasLikedByUser($userId)
    {
        return Sastra::select(['sastras.*'])
            ->join('likes', 'sastras.id', '=', 'likes.sastra_id')
            ->where('is_delete', false)
            ->where('likes.author_id', $userId)
            ->orderBy('likes.created_at', 'DESC')
            ->paginate(10);
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
            return JsonResponseHelper::respondErrorNotFound("sastra tidak ditemukan");
        }

        return JsonResponseHelper::respondSuccess([
            "sastras" => $sastras,
        ]);
    }

    public function store(SastraStoreRequest $request)
    {
        $validatedData = $request->validatedData();

        $sastra = Sastra::create($validatedData);

        if ($sastra) {
            return JsonResponseHelper::respondSuccess([
                "addedSastra" => [
                    "title" => $sastra->title,
                    "body" => $sastra->body,
                    "penulis" => $sastra->penulis,
                    "slug" => $sastra->slug
                ]
            ], 201);
        } else {
            return JsonResponseHelper::respondFail("sastra gagal ditambahkan");
        }
    }

    public function delete(Request $request)
    {
        $sastra = Sastra::where('id', $request->id)->first();

        if (!$sastra) {
            return JsonResponseHelper::respondErrorNotFound("sastra tidak ditemukan");
        }

        if ($sastra->author_id !== auth()->user()->id) {
            return JsonResponseHelper::respondErrorForbidden("Anda tidak berhak mengakses resource ini");
        }

        $sastra->update(['is_delete' => true]);

        return JsonResponseHelper::respondSuccess([], 204);
    }
}
