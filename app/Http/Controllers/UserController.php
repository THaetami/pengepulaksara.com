<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sastra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Contracts\Service\Attribute\Required;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store', 'search', 'userDetail']]);
    }

    public function index()
    {
        $user = auth()->user();
        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'max:14', 'min:4', 'regex:/^[a-zA-Z ]*$/'],
            'username' => ['required', 'max:10', 'min:6', 'unique:users', 'regex:/^[a-zA-Z0-9]*$/'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => ['required', 'max:12', 'min:5', 'regex:/^[a-zA-Z0-9]*$/'],
        ];

        $messages = [
            'required' => 'harus diisi',
            'max' => 'maksimal :max karakter',
            'min' => 'minimal :min karakter',
            'unique' => 'sudah digunakan',
            'email' => 'format email tidak valid',
            'name.regex' => 'gunakan alphabet dan spasi',
            'username.regex' => 'gunakan karakter alfanumerik',
            'password.regex' => 'gunakan karakter alfanumerik',
        ];

        $validated = $request->validate($rules, $messages);
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        if ($user) {
            return response()->json([
                "status" => "success",
                "data" => [
                    "addedUser" => [
                        "id" => $user->id,
                        "username" => $user->username
                    ]
                ]
            ], 201);
        } else {
            return response()->json([
                "status" => "fail",
                "message" => "User gagal ditambahkan"
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|max:14|min:4|regex:/^[a-zA-Z ]*$/',
        ];

        if ($request->username != $user->username) {
            $rules['username'] = 'required|min:6|max:10|unique:users|regex:/^[a-zA-Z0-9]*$/';
        }

        if ($request->email != '' && $request->email != $user->email) {
            $rules['email'] = 'required|unique:users|email:rfc,dns';
        }

        if ($request->password != '') {
            $rules['password'] = 'required|min:5|max:12|regex:/^[a-zA-Z0-9]*$/';
        }

        $customMessages = [
            'required' => ':attribute diperlukan',
            'max' => ':attribute maksimal :max karakter',
            'min' => ':attribute minimal :min karakter',
            'unique' => ':attribute sudah digunakan',
            'email' => 'format email tidak valid',
            'name.regex' => 'gunakan alphabet dan spasi',
            'username.regex' => 'gunakan alfanumerik',
            'password.regex' => 'gunakan alfanumerik',
        ];

        $validatedData = $request->validate($rules, $customMessages);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $validatedData['id'] = $user->id;

        User::where('id', User::where('id', $user->id)->pluck('id'))->update($validatedData);
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

        if ($q) {

            $sastras =
                Sastra::where(function ($query) use ($q) {
                    $query->where('title', 'like', "%{$q}%")
                        ->orWhere('penulis', 'like', "%{$q}%")
                        ->orWhere('body', 'like', "%{$q}%");
                })
                ->where('is_delete', false)
                ->with(['comment' => function ($query) {
                    $query->where('is_delete', false);
                }])
                ->paginate(10);
            // dd($sastras);

            return response()->json([
                "status" => "success",
                "data" => [
                    "sastras" => $sastras
                ]
            ]);
        } elseif ($user) {
            $user = User::select('name', 'username', 'created_at')
                ->where('username', 'like', '%' . $user . '%')
                ->orderBy('username')
                ->paginate(10);
            return response()->json([
                'status' => "success",
                'data' => $user
            ]);
        } else {
            return response()->json([
                "status" => "fail",
                "message" => "Permintaan pencarian diperlukan."
            ], 400);
        }
    }

    public function userDetail(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        return response()->json([
            "status" => "success",
            "user" => $user,
        ]);
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
