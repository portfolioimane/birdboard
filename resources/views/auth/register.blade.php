@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="text-2xl font-normal mb-10 text-center">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
                        @csrf

                        <div class="field mb-6">
                            <label for="name" class="label text-sm mb-2 block">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="input bg-transparent border border-grey rounded p-2 text-xs w-full  @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="field mb-6">
                            <label for="email" class="label text-sm mb-2 block">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="input bg-transparent border border-grey rounded p-2 text-xs w-full  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="password" type="password" class="input bg-transparent border border-grey rounded p-2 text-xs w-full @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="field mb-6">
                            <label for="password-confirm" class="label text-sm mb-2 block">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="input bg-transparent border border-grey rounded p-2 text-xs w-full" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="field mb-6">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="button is-link mr-2">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
