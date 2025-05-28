@extends('structure')
@section('title','Lista Utenti')
@section('content')
    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col d-flex justify-content-start">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-dark">Logout</button>
                </form>
            </div>
            <div class="col d-flex justify-content-end">
                <a href="{{ route('users.create') }}" class="btn btn-dark">Aggiungi utente</a>
            </div>
        </div>
        <div>
            <h1 class="m-0">Lista utenti</h1>
        </div>
        <form method="GET" action="{{ route('users.index') }}" class="row g-2 mb-4 mt-2">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Cerca per nome o email" } >
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-dark w-100">Cerca</button>
            </div>
        </form>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Azioni</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary me-1">Modifica</a>
                        <form action="{{ url('/users/'.$user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger delete-btn me-1">Elimina</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4 d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
@endsection
