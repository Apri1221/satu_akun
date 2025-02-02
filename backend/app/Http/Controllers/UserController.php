<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
// gunakan ini untuk autentikasi
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {   
        // uncomment this to enable auth for entire class
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }

    /**
     * Get all User.
     *
     * @return Response
     */
    public function allUsers()
    {
        return response()->json(['users' => User::all()], 200);
    }

    public function getUser($id_user) {
        return response()->json(['users' => User::with('social_media')->find($id_user)], 200);
    }

    /**
     * detele user ada di auth
     */
    public function deleteUser($id_user) {
        $user = User::findOrFail($id_user);
        try {
            $user->delete = 1;
            $user->touch();
            $user->save();
            // pertama harus soft delete dulu, dengan ubah status delete jadi 1
            // lalu nanti harus masuk waiting list admin, biar admin yg hapus data usernya
            // dan semua data yg berelasi dengan tabel tabel lain
            return response()->json(['user' => $user, 'message' => 'UPDATED'], 201);
        } catch (\Exception $e) {
            // return error message
            return response()->json(['message' => $e], 409);
        }
    }
    

    public function changeStatusUser($id_user, $status) {
        $user = User::where(['id' => $id_user])->first();
        try {
            $user->status = $status;
            $user->save();
            $user->touch();
            return response()->json(['message' => 'SUCCESS', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 409);
        }
    }
}