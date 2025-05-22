@extends('structure')
@section('title','Aggiungi nuovo utente')
@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Aggiungi nuovo utente</h1>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (provvisoria)</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Salva</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Annulla</a>
    </form>
</div>
