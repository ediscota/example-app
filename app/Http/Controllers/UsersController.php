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
        $this->validateUser($request);
        User::create($request->all());
        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->validateUserUpdate($request, $id);
        $user = User::find($id);
        $user->update($request->all());
        return redirect()->route('users.index');
    }
    public function destroy($id)
    {
        if (User::find($id)) {
            $user = User::find($id);
            $user->delete();
        }
        return redirect()->route('users.index');
    }
    protected function validateUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string|min:4|',
        ]);
    }
    protected function validateUserUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns'
        ]);
    }
}
