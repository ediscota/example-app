<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Request;


class UsersController extends Controller{

    public function index(){
        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function create(){
         //crea view
    }
    public function store(Request $request){

    }
    public function edit($id){

    }
    public function update(Request $request, $id){

    }
    public function destroy($id){

    }
}
