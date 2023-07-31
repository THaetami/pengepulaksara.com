<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Helpers\JsonResponseHelper;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sastra;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store', 'search', 'userDetail']]);
    }

    public function index()
    {
        $user = auth()->user();
        return JsonResponseHelper::respondSuccess([
            "user" => $user,
        ]);
    }

    public function store(UserRegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if ($user) {
            return JsonResponseHelper::respondSuccess([
                "addedUser" => [
                    "id" => $user->id,
                    "username" => $user->username
                ]
            ], 201);
        } else {
            return JsonResponseHelper::respondFail("user gagal ditambahkan", 400);
        }
    }

    public function update(UserUpdateRequest $request)
    {
        $user = auth()->user();

        $validatedData = $request->validated();

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $validatedData['id'] = $user->id;

        User::where('id', $user->id)->update($validatedData);
        Sastra::where('author_id', auth()->user()->id)->update(['penulis' => $request->username]);

        return response()->json([
            "status" => "success",
            "message" => "Data user berhasil diupdate",
        ]);
    }

    public function search(Request $request)
    {
        $user = $request->get('user');
        $q = $request->get('q');

        if (!$q && !$user) {
            return JsonResponseHelper::respondFail("permintaan pencarian diperlukan");
        }

        if ($q) {
            $sastras = Sastra::search($q)
                ->with(['comment' => function ($query) {
                    $query->where('is_delete', false);
                }])
                ->paginate(10);

            return JsonResponseHelper::respondSuccess([
                "sastras" => $sastras,
            ]);
        }

        if ($user) {
            $users = User::searchByUsername($user)
                ->paginate(10);

            return JsonResponseHelper::respondSuccess([
                "users" => $users,
            ]);
        }
    }

    public function crop(Request $request)
    {
        $request->validate([
            'show' => 'image|file|max:300'
        ]);

        $dest = 'storage/upload/'; //where user images will be stored
        $file = $request->file('img');

        $new_image_name = 'UIMG' . date('YmdHis') . uniqid() . '.jpg';

        // //upload file
        $move = $file->move(public_path($dest), $new_image_name);

        if (!$move) {
            return response()->json(['status' => 0, 'msg' => 'file size max 300kb']);
        } else {
            $userInfo = User::where('id', auth()->user()->id)->pluck('image')->first();

            if ($userInfo != '') {
                unlink($dest . $userInfo);
            }

            $user = User::find(auth()->user()->id);
            $user->image = $new_image_name;
            $user->save();

            return response()->json(['status' => 1, 'msg' => 'Your profile pricture updated', 'name' => $new_image_name]);
        }
    }
}
