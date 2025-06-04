<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersControllerAPI extends Controller
{
    public function getUsersWithComments()
    {
        $users = User::with('comments')->get();
        return response()->json($users);
    }

    public function getUserRoles($userId)
    {
        $user = User::with('roles')->findOrFail($userId);
        return response()->json($user);
    }
    public function getAdmins()
    {
        $admins = User::whereHas('roles', function ($query){
            $query->where('name', 'Admin');})->get();
        return response()->json($admins);
    }

}
