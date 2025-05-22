<?php
namespace App\Http\Controllers;
use App\Models\User;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']), // cripta la password
        ]);
        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email']));//update richiede array
        return redirect()->route('users.index')->with('success', 'Utente aggiornato con successo');
    }

    public function destroy($id)
    {
        if (User::find($id)) {
            $user = User::find($id);
            $user->delete();
            return redirect()->route('users.index');
        }
    }
}
