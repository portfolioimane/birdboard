@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="text-2xl font-normal mb-10 text-center">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
                        @csrf

                        <div class="field mb-6">
                            <label for="email" class="label text-sm mb-2 block">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="input bg-transparent border border-grey rounded p-2 text-xs w-full @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="field mb-6">
                            <label for="password" class="label text-sm mb-2 block">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="input bg-transparent border border-grey rounded p-2 text-xs w-full @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="field mb-6">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" value="{{ old('remember') ? 'checked' : '' }}">

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="field mb-6">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="button is-link mr-2">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
