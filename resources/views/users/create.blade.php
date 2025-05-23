@extends('structure')
@section('title', 'Aggiungi nuovo utente')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-dark rounded-4 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-center text-dark mb-4">
                            <i class="bi bi-person-plus me-2"></i>Aggiungi Nuovo Utente
                        </h2>
                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3">
                                <ul class="mb-0 list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="bi bi-person me-1"></i>Nome
                                </label>
                                <input type="text" name="name" class="form-control rounded-3 ps-4" placeholder="Inserisci nome">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope me-1"></i>Email
                                </label>
                                <input type="email" name="email" class="form-control rounded-3 ps-4" placeholder="Inserisci email">
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock me-1"></i>Password
                                </label>
                                <input type="password" name="password" class="form-control rounded-3 ps-4" placeholder="Inserisci password">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-dark w-50 me-2 rounded-3">Salva</button>
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary w-50 rounded-3">Annulla</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
