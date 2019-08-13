@extends('layouts.app')

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                    <span class="login100-form-title">
                        تسجيل الدخول
                    </span>
                       <form method="POST" action="{{ route('admin.login.submit') }}" class="login100-form validate-form p-l-55 p-r-55 p-t-178">
                        @csrf
                                <div class="wrap-input100 validate-input m-b-16">
                                <input class="input100" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="البريد الالكتروني">
                               <span class="focus-input100"></span>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="wrap-input100 validate-input">
                                <input id="password" type="password" class="input100" name="password" required autocomplete="current-password" placeholder="كلمة المرور">
                                <span class="focus-input100"></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="text-right p-t-13 p-b-23">
                                </div>

{{--                         <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                                <div class="container-login100-form-btn">
                                    <button type="submit" class="login100-form-btn">
                                        {{ __('Login') }}
                                    </button>
                                </div>

                        <div class="flex-col-c p-t-170 p-b-40">

                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
