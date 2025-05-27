@extends('structure')
@section('title', 'Login')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-dark rounded-4 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-center text-dark mb-4">
                            <i class="bi bi-person-circle me-2"></i>Login
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
                        <form method="POST" action="{{ route('login.perform') }}">
                            @csrf
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
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-dark w-50 rounded-3">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
