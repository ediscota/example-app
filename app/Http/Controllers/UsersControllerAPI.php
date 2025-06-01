<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersControllerAPI extends Controller
{
    public function getIndex()
    {
    $users = User::all();
    return response()->json($users);
    }
}
