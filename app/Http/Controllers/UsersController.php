<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Request;


class UsersController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        //crea view
    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);
        $user = User::findOrFail($id);
        $user->update($validated);
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
