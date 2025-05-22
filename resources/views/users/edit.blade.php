@extends('structure')
@section('title','Modifica Utenti')
@section('content')
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Modifica Utente</h2>
            <form action="{{ url('/users/' . $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                           value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Salva modifiche</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Annulla</a>
                </div>
            </form>

        </div>
    </div>
@endsection
