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
}
