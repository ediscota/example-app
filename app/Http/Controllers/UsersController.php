<?php
namespace App\Http\Controllers;
use App\Models\User;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = DB::table('users')->when($search, function ($query, $search) {$query->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%");})->paginate(3)->withQueryString();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validator = $this->validateUser($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        User::create(['name' => $request->input('name'), 'email' => $request->input('email'), 'password' => Hash::make($request->input('password')),]);
        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validateUserUpdate($request, $id);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
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
        $messages = [
            'required' => 'Il campo :attribute è obbligatorio.',
            'string' => 'Il campo :attribute deve essere una stringa.',
            'email' => 'Il campo :attribute deve essere un indirizzo email valido.',
            'min' => 'Il campo :attribute deve contenere almeno :min caratteri.',
            'max' => 'Il campo :attribute non può superare i :max caratteri.',
            'unique' => 'Il campo :attribute è già stato utilizzato.',
        ];
        $rules = [
            'name' => 'required|string|unique:users',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string|min:4'
        ];

        return Validator::make($request->all(), $rules, $messages);
    }
    protected function validateUserUpdate(Request $request, $id)
    {
        $messages = [
            'required' => 'Il campo :attribute è obbligatorio.',
            'string' => 'Il campo :attribute deve essere una stringa.',
            'email' => 'Il campo :attribute deve essere un indirizzo email valido.',
            'unique' => 'La mail inserita è già stata usata.',
        ];
        $rules = [
            'name' => 'required|string|unique:users',
            'email' => 'required|email:rfc,dns'
        ];
        return Validator::make($request->all(), $rules, $messages);
    }
}
