@extends('structure')
@section('title','Modifica Utente')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-dark rounded-4 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-center text-dark mb-4">
                            <i class="bi bi-pencil-square me-2"></i>Modifica Utente
                        </h2>
                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ url('/users/' . $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="bi bi-person me-1"></i>Nome
                                </label>
                                <input type="text" name="name" id="name"
                                       class="form-control rounded-3 ps-4"
                                       placeholder="Inserisci nuovo nome"
                                       value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope me-1"></i>Email
                                </label>
                                <input type="email" name="email" id="email"
                                       class="form-control rounded-3 ps-4"
                                       placeholder="Inserisci nuova email"
                                       value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-dark w-50 me-2 rounded-3">Salva modifiche</button>
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary w-50 rounded-3">Annulla</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
